<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Integration\Providers;

use Illuminate\Container\Container;
use JournalMedia\Pharbiter\Console\Kernel;
use JournalMedia\Pharbiter\Providers\ConsoleServiceProvider;
use JournalMedia\PharbiterTest\Integration\IntegrationTestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ConsoleServiceProviderTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_binds_a_symfony_console_kernel_to_our_kernel()
    {
        // Create test container
        $container = new Container;

        // Create the service provider and register it with the test container
        (new ConsoleServiceProvider($container))->register();

        // Assert that our Kernel behaves as expected with the Symfony Kernel binding
        $container[Kernel::class]->handle(
            new ArgvInput([
                "pharb",
                "help"
            ]),
            $output = new BufferedOutput
        );

        $this->assertContains(
            "Usage:\n",
            $output->fetch()
        );
    }
}
