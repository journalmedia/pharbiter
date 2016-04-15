<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Check;

use JournalMedia\Pharbiter\Test\Reader;

class CheckQuery
{
    /** @var Reader */
    private $reader;

    /** @var Checker */
    private $checker;

    public function __construct(Reader $reader, Checker $checker)
    {
        $this->reader = $reader;
        $this->checker = $checker;
    }

    public function __invoke(TestCaseLocation $testCaseLocation, TestName $testName): string
    {
        return $this->checker->check(
            $this->reader->readTest($testCaseLocation, $testName)
        );
    }
}
