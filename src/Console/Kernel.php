<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel
{
    /** @var Application */
    private $adaptedKernel;

    public function __construct(Application $adaptedKernel)
    {
        $this->adaptedKernel = $adaptedKernel;
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $this->adaptedKernel->run($input, $output);
    }
}
