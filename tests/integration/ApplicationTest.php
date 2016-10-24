<?php
declare(strict_types=1);

namespace JournalMedia\PharbiterTest\Integration;

use Composer\Autoload\ClassLoader as ComposerClassLoader;
use Illuminate\Container\Container;
use JournalMedia\Pharbiter\Application;
use JournalMedia\Pharbiter\ClassLoader;
use JournalMedia\Pharbiter\Console\Kernel;
use JournalMedia\Pharbiter\Providers\ConsoleServiceProvider;

class ApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_an_instance_of_something_in_its_container()
    {
        $application = $this->createApplication();

        $kernel = $application->make(Kernel::class);

        $this->assertInstanceOf(
            Kernel::class,
            $kernel
        );
    }

    /**
     * @test
     */
    public function it_registers_a_class_loader()
    {
        $application = $this->createApplication();

        $classLoader = $application->make(ClassLoader::class);

        $this->assertInstanceOf(
            ClassLoader::class,
            $classLoader
        );
    }

    /**
     * @test
     */
    public function it_registers_all_service_providers()
    {
        // Create test container
        $expectedContainer = new Container;

        // Register class loader as the application does
        $expectedContainer[ClassLoader::class] = new ClassLoader(new ComposerClassLoader);

        // Register all service providers with the test container
        (new ConsoleServiceProvider($expectedContainer))->register();

        // Assert that our application's container matches the test container
        $this->assertEquals(
            $expectedContainer,
            $this->createApplication()->getContainer()
        );
    }

    private function createApplication()
    {
        return new Application(new ComposerClassLoader);
    }
}
