<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Console;

use Symfony\Component\Console\Application;

class Kernel
{
    /** @var Application */
    private $adaptedKernel;

    public function __construct(Application $adaptedKernel)
    {
        $this->adaptedKernel = $adaptedKernel;
    }

    public function handle()
    {
        $this->adaptedKernel->run();
    }
}
