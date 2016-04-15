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
}
