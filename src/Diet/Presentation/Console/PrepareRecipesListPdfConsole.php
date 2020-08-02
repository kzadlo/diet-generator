<?php

declare(strict_types=1);

namespace App\Diet\Presentation\Console;

use App\Diet\Application\Query\GetRecipesList;
use App\Diet\Application\QueryBus;
use App\Diet\Application\Service\PdfGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareRecipesListPdfConsole extends Command
{
    protected static $defaultName = 'recipes-list:prepare-pdf';

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
            ->setDescription('Prepares a recipes list in pdf')
            ->setHelp('This command allows you to prepare pdf file with all recipes list');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Preparing recipes list pdf...',
        ]);

        $getRecipesList = new GetRecipesList();
        $dataToPdf['recipes'] = $this->queryBus->dispatch($getRecipesList);

        $this->pdfGenerator->generate($dataToPdf);

        $output->writeln([
            'Done! Enjoy your meals!'
        ]);
    }
}
