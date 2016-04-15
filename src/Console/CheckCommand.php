<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Console;

use JournalMedia\Pharbiter\Check\CheckQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends Command
{
    /** @var CheckQuery */
    private $query;

    public function __construct(CheckQuery $query)
    {
        $this->query = $query;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('check');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->query->__invoke());
    }
}
