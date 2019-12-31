<?php

namespace App\UI\Console\Offer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Application\Command\Offer\IncrementVersion as IncrementVersionCommand;

class IncrementVersion extends Command
{
    protected static $defaultName = 'app:offer:increment';

    private MessageBusInterface $messageBus;

    public function __construct(string $name = null, MessageBusInterface $messageBus)
    {
        parent::__construct($name);
        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this
            ->setDescription('Increment Offer version by CLI')
            ->addArgument('uuid', InputArgument::REQUIRED, 'Uuid')
            ->addArgument('version', InputArgument::OPTIONAL, 'Type of the version', 'patch');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Increment of an offer...');
        $this->messageBus->dispatch(
            new IncrementVersionCommand($input->getArgument('version'), $input->getArgument('uuid'))
        );

        return 0;
    }
}
