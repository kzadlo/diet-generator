<?php

declare(strict_types=1);

namespace App\Diet\Presentation\Console;

use App\Diet\Application\Query\GetShoppingListProduct;
use App\Diet\Application\QueryBus;
use App\Diet\Application\Service\ShoppingListPdfGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareShoppingListPdfConsole extends Command
{
    protected static $defaultName = 'shopping-list:prepare-pdf';

    private $queryBus;

    private $shoppingListPdfGenerator;

    public function __construct(QueryBus $queryBus, ShoppingListPdfGenerator $shoppingListPdfGenerator)
    {
        $this->queryBus = $queryBus;
        $this->shoppingListPdfGenerator = $shoppingListPdfGenerator;

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
            'Preparing pdf...',
        ]);

        $getShoppingListProduct = new GetShoppingListProduct($startDate, $endDate);

        $products = $this->queryBus->dispatch($getShoppingListProduct);

        $this->shoppingListPdfGenerator->generate($products, $startDate, $endDate);

        $output->writeln([
            'Done. Enjoy your meals!'
        ]);
    }
}
