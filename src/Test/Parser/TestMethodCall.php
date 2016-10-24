<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test\Parser;

use Illuminate\Support\Collection;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;

class TestMethodCall implements TestNode
{
    public static function fromMethodCall(MethodCall $wrappedMethodCall)
    {
        $callee = $wrappedMethodCall->var;

        if ($callee instanceof MethodCall) {
            $callee = self::fromMethodCall($callee);
        }

        if ($callee instanceof Variable) {
            $callee = TestVariable::fromVariable($callee);
        }

        return new self($callee, $wrappedMethodCall);
    }

    /** @var TestNode */
    private $callee;

    /** @var MethodCall */
    private $wrappedMethodCall;

    private function __construct(TestNode $callee, MethodCall $wrappedMethodCall)
    {
        $this->callee = $callee;
        $this->wrappedMethodCall = $wrappedMethodCall;
    }

    public function isCallOnAProphecy(Collection $prophecyAssignments): bool
    {
        return $this->callee->isCallOnAProphecy($prophecyAssignments);
    }

    public function getRootVariable(): Variable
    {
        return $this->callee->getRootVariable();
    }

    public function getFirstMethodCallInChain(): MethodCall
    {
        if ($this->callee instanceof self) {
            return $this->callee->getFirstMethodCallInChain();
        }

        return $this->wrappedMethodCall;
    }
}
