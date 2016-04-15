<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Unit\Check;

use JournalMedia\Pharbiter\Check\Checker;
use JournalMedia\Pharbiter\Check\CheckQuery;
use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;
use JournalMedia\Pharbiter\Test\Double;
use JournalMedia\Pharbiter\Test\Reader;
use JournalMedia\Pharbiter\Test\Test;
use JournalMedia\PharbiterTest\Unit\UnitTestCase;

class CheckQueryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function can_be_invoked()
    {
        // Explicit collaborators
        $reader = $this->prophesize(Reader::class);
        $checker = $this->prophesize(Checker::class);

        $testCaseLocation = TestCaseLocation::fromString("some/path/TestFile.php");
        $testName = TestName::fromString("some_test_method_name");

        $query = new CheckQuery($reader->reveal(), $checker->reveal());

        // Implicit collaborators
        $test = Test::fromDoubles(collect());

        /** @contract ? */
        $reader->readTest($testCaseLocation, $testName)
            ->willReturn($test);

        /** @contract ? */
        $checker->check($test)
            ->willReturn("Some check result");

        $result = $query($testCaseLocation, $testName);

        $this->assertSame(
            "Some check result",
            $result
        );
    }
}
