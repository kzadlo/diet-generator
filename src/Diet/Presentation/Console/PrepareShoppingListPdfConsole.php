<?php

declare(strict_types=1);

namespace App\Diet\Presentation\Console;

use App\Diet\Application\Query\GetShoppingListProduct;
use App\Diet\Application\QueryBus;
use App\Diet\Application\Service\PdfGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareShoppingListPdfConsole extends Command
{
    protected static $defaultName = 'shopping-list:prepare-pdf';

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
            ->addArgument('startDate', InputArgument::REQUIRED, 'When shopping list should start')
            ->addArgument('endDate', InputArgument::REQUIRED, 'When shopping list should end')
            ->setDescription('Prepares a shopping list in pdf')
            ->setHelp('This command allows you to prepare pdf file with shopping list for period');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startDate = $input->getArgument('startDate');
        $endDate = $input->getArgument('endDate');

        $output->writeln([
            'Preparing shopping list pdf...',
        ]);

        $getShoppingListProduct = new GetShoppingListProduct($startDate, $endDate);
        $dataToPdf['products'] = $this->queryBus->dispatch($getShoppingListProduct);
        $dataToPdf['startDate'] = $startDate;
        $dataToPdf['endDate'] = $endDate;

        $this->pdfGenerator->generate($dataToPdf);

        $output->writeln([
            'Done! Now you can go shopping.'
        ]);
    }
}
