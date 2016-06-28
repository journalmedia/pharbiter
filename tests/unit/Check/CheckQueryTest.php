<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Unit\Check;

use JournalMedia\Pharbiter\Check\Checker;
use JournalMedia\Pharbiter\Check\CheckQuery;
use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;
use JournalMedia\Pharbiter\Test\DoubleMethodConfiguration;
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
        $reader = $this->prophesize('JournalMedia\Pharbiter\Test\Reader');
        $checker = $this->prophesize('JournalMedia\Pharbiter\Check\Checker');

        $testCaseLocation = TestCaseLocation::fromString("some/path/TestFile.php");
        $testName = TestName::fromString("some_test_method_name");

        $query = new CheckQuery($reader->reveal(), $checker->reveal());

        // Implicit collaborators
        $test = Test::fromDoubleMethodConfigurations(collect());

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
