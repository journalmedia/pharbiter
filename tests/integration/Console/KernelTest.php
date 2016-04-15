<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Integration\Console;

use JournalMedia\Pharbiter\Console\Kernel;
use JournalMedia\PharbiterTest\Integration\IntegrationTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class KernelTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_can_handle_a_run()
    {
        $kernel = new Kernel($this->createSymfonyKernel());

        $kernel->handle(
            new ArgvInput(["console", "fake:command"]),
            $output = new BufferedOutput
        );

        $this->assertSame(
            "Fake command ran\n",
            $output->fetch()
        );
    }

    private function createSymfonyKernel(): Application
    {
        $symfonyKernel = new Application();
        $symfonyKernel->setAutoExit(false);

        $symfonyKernel->add(new class() extends Command
        {
            protected function configure()
            {
                $this->setName('fake:command');
            }

            protected function execute(InputInterface $input, OutputInterface $output) {
               $output->writeln("Fake command ran");
            }
        });

        return $symfonyKernel;
    }
}
