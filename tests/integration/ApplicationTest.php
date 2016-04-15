<?php
declare(strict_types=1);

class ApplicationTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_can_make_an_instance_of_something_in_its_container()
    {
        $application = new \JournalMedia\Pharbiter\Application;

        $kernel = $application->make(\JournalMedia\Pharbiter\Console\Kernel::class);

        $this->assertInstanceOf(
            \JournalMedia\Pharbiter\Console\Kernel::class,
            $kernel
        );
    }

    /**
     * @test
     */
    public function it_registers_all_service_providers()
    {
        $application = new \JournalMedia\Pharbiter\Application;

        $expectedContainer = new Illuminate\Container\Container;

        (new \JournalMedia\Pharbiter\Providers\ConsoleServiceProvider($expectedContainer))->register();

        $this->assertEquals(
            $expectedContainer,
            $application->getContainer()
        );
    }
}
