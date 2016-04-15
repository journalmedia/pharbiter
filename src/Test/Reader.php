<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test;

use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;
use JournalMedia\Pharbiter\ClassLoader;
use JournalMedia\Pharbiter\Filesystem;

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
        $className = $this->classLoader->getClassName(strval($testCaseLocation));

        $reflection = new \ReflectionClass($className);
        $method = $reflection->getMethod(strval($name));

        $code = $this->filesystem->readBetween(strval($testCaseLocation), $method->getStartLine(), $method->getEndLine());

        $code = collect(explode("\n", $code))
            ->map(function ($line) {
                return trim($line);
            })
            ->reject(function ($line) {
                return $line === "";
            });

        $phpVariableRegex = '\$([a-zA-Z_][a-zA-Z0-9_]*)';
        $phpClassRegex = '([a-zA-Z_\x7f-\xff][\\a-zA-Z0-9_\x7f-\xff]*)';
        $phpMethodRegex = '([a-zA-Z_][a-zA-Z0-9_]*)';
        $prophesizeRegex = sprintf('\$this->prophesize\([\'"]%s[\'"]\)', $phpClassRegex);
        $prophecyAssignmentRegex = sprintf(
            '#%s\s+=\s+%s#',
            $phpVariableRegex,
            $prophesizeRegex
        );

        $prophets = $code
                ->filter(function ($line) use ($prophecyAssignmentRegex) {
                    return preg_match($prophecyAssignmentRegex, $line) === 1;
                })
                ->map(function ($line) use ($prophecyAssignmentRegex) {
                    preg_match($prophecyAssignmentRegex, $line, $matches);
                    return $matches;
                })
                ->keyBy(function ($matches) {
                    return $matches[1];
                })
                ->map(function ($matches) {
                    return $matches[2];
                });

        $methodCallRegex = sprintf('/%s->%s\(/', $phpVariableRegex, $phpMethodRegex);

        $prophetMethodCalls = $code
            ->filter(function ($line) use ($methodCallRegex) {
                return preg_match($methodCallRegex, $line) === 1
                    && preg_match('/\$this->/', $line) !== 1;
            })
            ->map(function ($line, $lineNumber) use ($methodCallRegex) {
                preg_match($methodCallRegex, $line, $matches);
                return [
                    'line'     => $lineNumber,
                    'variable' => $matches[1],
                    'method'   => $matches[2],
                ];
            })
            ->filter(function ($methodCall) use ($prophets) {
                return $prophets->contains(function ($key) use ($methodCall) {
                    return $key === $methodCall['variable'];
                });
            });

        $contractAnnotationRegex = sprintf('/\/\*\* @contract %s::%s \*\//', $phpClassRegex, $phpMethodRegex);

        $callsWithoutAnnotations = $prophetMethodCalls
            ->reject(function ($methodCall) use ($code, $contractAnnotationRegex) {
                $annotationLine = $methodCall['line'] - 1;
                return isset($code[$annotationLine])
                    && preg_match($contractAnnotationRegex, $code[$annotationLine]) === 1;
            });

        return Test::fromDoubles($callsWithoutAnnotations
            ->map(function ($methodCall) use ($prophets) {
                return Double::fromClassAndMethod($prophets[$methodCall['variable']], $methodCall['method']);
            })
            ->values());
    }
}
