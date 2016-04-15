<?php
declare(strict_types=1);

class CheckCommandTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_executes_a_domain_check_query()
    {
        $query = $this->prophesize(\JournalMedia\Pharbiter\Check\CheckQuery::class);

        $command = new \JournalMedia\Pharbiter\Console\CheckCommand($query->reveal());

        $input = new \Symfony\Component\Console\Input\ArgvInput([
            $command->getName(),
            "some/path/TestFile.php",
            "some_test_method_name"
        ]);
        $output = new \Symfony\Component\Console\Output\BufferedOutput;

        /** @contract ? */
        $query->__invoke(
            \JournalMedia\Pharbiter\Check\TestCaseLocation::fromString("some/path/TestFile.php"),
            \JournalMedia\Pharbiter\Check\TestName::fromString("some_test_method_name")
        )
            ->willReturn("Query result");

        $command->run($input, $output);

        $this->assertSame(
            "Query result\n",
            $output->fetch()
        );
    }
}
