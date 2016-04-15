<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Integration\Console;

use JournalMedia\Pharbiter\Check\CheckQuery;
use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;
use JournalMedia\Pharbiter\Console\CheckCommand;
use JournalMedia\PharbiterTest\Integration\IntegrationTestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class CheckCommandTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_executes_a_domain_check_query()
    {
        // Explicit dependencies
        $query = $this->prophesize(CheckQuery::class);

        $command = new CheckCommand($query->reveal());

        // Input for method under test
        $input = new ArgvInput([
            $command->getName(),
            "some/path/TestFile.php",
            "some_test_method_name"
        ]);
        $output = new BufferedOutput;

        /** @contract ? */
        $query->__invoke(
            TestCaseLocation::fromString("some/path/TestFile.php"),
            TestName::fromString("some_test_method_name")
        )
            ->willReturn("Query result");

        $command->run($input, $output);

        $this->assertSame(
            "Query result\n",
            $output->fetch()
        );
    }
}
