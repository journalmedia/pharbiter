<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Integration;

use Illuminate\Container\Container;
use JournalMedia\Pharbiter\Application;
use JournalMedia\Pharbiter\Console\Kernel;
use JournalMedia\Pharbiter\Providers\ConsoleServiceProvider;

class ApplicationTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_can_make_an_instance_of_something_in_its_container()
    {
        $application = new Application();

        $kernel = $application->make(Kernel::class);

        $this->assertInstanceOf(
            Kernel::class,
            $kernel
        );
    }

    /**
     * @test
     */
    public function it_registers_all_service_providers()
    {
        // Create test container
        $expectedContainer = new Container;

        // Register all service providers with the test container
        (new ConsoleServiceProvider($expectedContainer))->register();

        // Assert that our application's container matches the test container
        $this->assertEquals(
            $expectedContainer,
            (new Application)->getContainer()
        );
    }
}
