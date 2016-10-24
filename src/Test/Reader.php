<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test;

use Illuminate\Support\Collection;
use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;
use JournalMedia\Pharbiter\ClassLoader;
use JournalMedia\Pharbiter\Filesystem;
use JournalMedia\Pharbiter\Test\Parser\TestMethodCall;
use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\ParserFactory;
use Symfony\Component\Yaml\Exception\RuntimeException;

class Reader
{
    /** @var ClassLoader */
    private $classLoader;

    /** @var Filesystem */
    private $filesystem;

    public function __construct(ClassLoader $classLoader, Filesystem $filesystem)
    {
        $this->classLoader = $classLoader;
        $this->filesystem = $filesystem;
    }

    public function readTest(TestCaseLocation $testCaseLocation, TestName $name): Test
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        $tree = $parser->parse(file_get_contents(strval($testCaseLocation)));

        $class = $tree[1]->stmts[0];

        $testMethod = collect($class->stmts)
            ->filter(function ($node) {
                return $node instanceof ClassMethod;
            })
            ->first(function ($key, ClassMethod $node) use ($name) {
                return $node->name === strval($name);
            });

        $prophecyAssignments = collect($testMethod->stmts)
            ->filter(function ($node) {
                return $node instanceof Assign
                    && $node->expr instanceof MethodCall
                    && $node->expr->name === "prophesize";
            })
            ->map(function (Assign $node) {
                return ProphecyAssignment::fromAssign($node);
            });

        $methodCallsOnProphecies = collect($testMethod->stmts)
            ->filter(function ($node) {
                return $node instanceof MethodCall;
            })
            ->map(function (MethodCall $methodCall) {
                return TestMethodCall::fromMethodCall($methodCall);
            })
            ->filter(function (TestMethodCall $methodCall) use ($prophecyAssignments) {
                return $methodCall->isCallOnAProphecy($prophecyAssignments);
            });

        $methodCallsWithoutContracts = $methodCallsOnProphecies
            ->reject(function (TestMethodCall $methodCall) {
                return collect(
                        $methodCall->getRootVariable()
                            ->getAttribute("comments")
                )
                    ->contains(function ($key, $comment) {
                        return $comment instanceof Doc
                            && preg_match("#/\*\* @contract [a-zA-Z0-9\\?]+ \*/#", $comment->getText());
                    });
            });

        return Test::fromDoubleMethodConfigurations($methodCallsWithoutContracts
            ->map(function (TestMethodCall $methodCall) use ($prophecyAssignments) {
                return DoubleMethodConfiguration::fromClassAndMethod(
                    $prophecyAssignments
                        ->first(function ($key, ProphecyAssignment $prophecyAssignment) use ($methodCall) {
                            return $prophecyAssignment->getVariableName() === $methodCall->getRootVariable()->name;
                        })
                        ->getProphesizedClassName(),
                    $methodCall->getFirstMethodCallInChain()
                        ->name
                );
            })
            ->values());
    }
}
