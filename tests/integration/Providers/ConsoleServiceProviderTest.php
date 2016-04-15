<?php
declare(strict_types=1);

class ConsoleServiceProviderTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_binds_a_symfony_console_kernel_to_our_kernel()
    {
        $container = new Illuminate\Container\Container;

        $provider = new \JournalMedia\Pharbiter\Providers\ConsoleServiceProvider($container);

        $provider->register();

        $kernel = $container[\JournalMedia\Pharbiter\Console\Kernel::class];

        $input = new \Symfony\Component\Console\Input\ArgvInput(["pharb", "check"]);
        $output = new \Symfony\Component\Console\Output\BufferedOutput;

        $kernel->handle($input, $output);

        $this->assertSame(
            "Fake command ran\n",
            $output->fetch()
        );
    }
}
