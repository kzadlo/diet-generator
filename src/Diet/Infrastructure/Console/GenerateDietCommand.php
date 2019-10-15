<?php

namespace App\Diet\Infrastructure\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDietCommand extends Command
{
    protected static $defaultName = 'app:generate-diet';

    protected function configure()
    {
        $this
            ->setDescription('Generates a new diet')
            ->setHelp('This command allows you to generate diet for new period');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @todo implment diet generator */
        $output->writeln([
            'Generating diet.',
            '...',
            'Diet was prepared. Thank you!',
        ]);
    }
}