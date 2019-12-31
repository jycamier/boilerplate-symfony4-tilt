<?php


namespace App\UI\Console\Offer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Application\Command\Offer\CreateOffer as CommandCreateOffer;


class CreateOffer extends Command
{
    protected static $defaultName = 'app:offer:create';

    private MessageBusInterface $messageBus;

    public function __construct(string $name = null, MessageBusInterface $messageBus)
    {
        parent::__construct($name);
        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create Offer by CLI')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the offer')
            ->addArgument(
                'uuid',
                InputArgument::OPTIONAL,
                'Uuid which can provided to create an offer with a specific one'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln('Creation of an offer...');

        $this->messageBus->dispatch(
            new CommandCreateOffer($input->getArgument('name'), $input->getArgument('uuid'))
        );

        return 0;
    }
}
