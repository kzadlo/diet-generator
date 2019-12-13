<?php

declare(strict_types=1);

namespace App\Diet\Presentation\Console;

use App\Diet\Application\Query\GetPeriodDiet;
use App\Diet\Application\Query\GetPeriodMealIngredient;
use App\Diet\Application\Query\GetPeriodMealRecipe;
use App\Diet\Application\QueryBus;
use App\Diet\Application\Service\PdfGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareDietPdfConsole extends Command
{
    protected static $defaultName = 'diet:prepare-pdf';

    private $queryBus;

    private $pdfGenerator;

    public function __construct(QueryBus $queryBus, PdfGeneratorInterface $pdfGenerator)
    {
        $this->queryBus = $queryBus;
        $this->pdfGenerator = $pdfGenerator;

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
        $output->writeln([
            'Preparing diet pdf...',
        ]);

        $getPeriodDiet = new GetPeriodDiet($input->getArgument('periodId'));
        $dataToPdf['periodDays'] = $this->queryBus->dispatch($getPeriodDiet);

        $getPeriodMealRecipe = new GetPeriodMealRecipe($input->getArgument('periodId'));
        $dataToPdf['periodRecipes'] = $this->queryBus->dispatch($getPeriodMealRecipe);

        $getPeriodMealIngredient = new GetPeriodMealIngredient($input->getArgument('periodId'));
        $dataToPdf['periodIngredients'] = $this->queryBus->dispatch($getPeriodMealIngredient);

        $this->pdfGenerator->generate($dataToPdf);

        $output->writeln([
            'Done! Enjoy your meals!'
        ]);
    }
}
