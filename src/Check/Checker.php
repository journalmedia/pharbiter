<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Check;

use JournalMedia\Pharbiter\Test\Test;

class Checker
{
    public function check(Test $test): string
    {
        return $test->getDoubles()
            ->map(function ($double) {
                return sprintf("No contract marked for %s::%s()", $double->getClassName(), $double->getMethodName());
            })
            ->implode("\n");
    }
}
