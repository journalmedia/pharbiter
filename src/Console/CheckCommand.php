<?php
declare(strict_types=1);

namespace JournalMedia\Pharbiter\Console;

use JournalMedia\Pharbiter\Check\CheckQuery;
use JournalMedia\Pharbiter\Check\TestCaseLocation;
use JournalMedia\Pharbiter\Check\TestName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
        $this->setName('check')
            ->addArgument(
                'test-case-location',
                InputArgument::REQUIRED
            )
            ->addArgument(
                'test-name',
                InputArgument::REQUIRED
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->query->__invoke(
            TestCaseLocation::fromString($input->getArgument('test-case-location')),
            TestName::fromString($input->getArgument('test-name'))
        ));
    }
}
