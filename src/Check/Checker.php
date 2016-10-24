<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Check;

use JournalMedia\Pharbiter\Test\Test;

class Checker
{
    public function check(Test $test): string
    {
        return $test->getDoubleMethodConfigurations()
            ->map(function ($doubleMethodConfiguration) {
                return sprintf(
                    "No contract marked for %s::%s()",
                    $doubleMethodConfiguration->getClassName(),
                    $doubleMethodConfiguration->getMethodName()
                );
            })
            ->implode("\n");
    }
}
