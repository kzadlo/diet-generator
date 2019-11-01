<?php

declare(strict_types=1);

namespace App\Diet\Presentation\Console;

use App\Diet\Application\Query\GetPeriodDiet;
use App\Diet\Application\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareDietPdfConsole extends Command
{
    protected static $defaultName = 'diet:prepare-pdf';

    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('periodId', InputArgument::REQUIRED, 'For which period you want prepare pdf')
            ->setDescription('Prepares a diet in pdf')
            ->setHelp('This command allows you to prepare pdf file with diet for period');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $getPeriodDiet = new GetPeriodDiet(
            $input->getArgument('periodId')
        );

        $output->writeln([
            'Preparing pdf...',
        ]);

        $periodMeals = $this->queryBus->dispatch($getPeriodDiet);

        $output->writeln([
            'Done. Enjoy your meals!'
        ]);
    }
}
