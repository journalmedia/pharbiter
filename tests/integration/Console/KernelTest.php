<?php
declare(strict_types=1);

class KernelTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_can_handle_a_run()
    {
        $kernel = new \JournalMedia\Pharbiter\Console\Kernel($this->createSymfonyKernel());

        $input = new \Symfony\Component\Console\Input\ArgvInput(["console", "fake:command"]);
        $output = new \Symfony\Component\Console\Output\BufferedOutput;

        $kernel->handle($input, $output);

        $this->assertSame(
            "Fake command ran\n",
            $output->fetch()
        );
    }

    private function createSymfonyKernel()
    {
        $symfonyKernel = new \Symfony\Component\Console\Application;
        $symfonyKernel->setAutoExit(false);

        $symfonyKernel->add(new class() extends \Symfony\Component\Console\Command\Command
        {
            protected function configure()
            {
                $this->setName('fake:command');
            }

            protected function execute(
                \Symfony\Component\Console\Input\InputInterface $input,
                \Symfony\Component\Console\Output\OutputInterface $output
            ) {
               $output->writeln("Fake command ran");
            }
        });

        return $symfonyKernel;
    }
}
