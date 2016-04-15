<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Test;

use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;

class Reader
{
    public function readTest(TestCaseLocation $testCaseLocation, TestName $name): Test
    {
        return new Test;
    }
}
