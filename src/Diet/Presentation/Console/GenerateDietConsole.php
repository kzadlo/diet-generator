<?php

declare(strict_types=1);

namespace App\Diet\Presentation\Console;

use App\Diet\Application\Command\GenerateDiet;
use App\Diet\Application\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDietConsole extends Command
{
    protected static $defaultName = 'diet:generate';

    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'For who you want generate diet?')
            ->addArgument('startDate', InputArgument::REQUIRED, 'When diet plan should start?')
            ->setDescription('Generates a new diet')
            ->setHelp('This command allows you to generate diet for new period');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generateDietCommand = new GenerateDiet(
            $input->getArgument('email'),
            $input->getArgument('startDate')
        );

        $output->writeln([
            'Generating diet...',
        ]);

        $this->commandBus->dispatch($generateDietCommand);

        $output->writeln([
           'Done. Enjoy your meals!'
        ]);
    }
}
