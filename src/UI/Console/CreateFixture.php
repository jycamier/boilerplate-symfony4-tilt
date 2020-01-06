<?php

namespace App\UI\Console;

use App\Application\Command\Offer\IncrementVersion;
use Faker\Generator;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateFixture extends Command
{
    protected static $defaultName = 'app:messenger:fixture';

    private MessageBusInterface $messageBus;
    private Generator $generator;
    private KernelInterface $kernel;

    public function __construct(
        string $name = null,
        MessageBusInterface $messageBus,
        Generator $generator,
        KernelInterface $kernel
    ) {
        parent::__construct($name);
        $this->messageBus = $messageBus;
        $this->generator = $generator;
        $this->kernel = $kernel;
    }

    protected function configure()
    {
        $this
            ->setDescription('Inject data via Symfony Messenger');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new ConsoleLogger($output);
        $io = new SymfonyStyle($input, $output);
        $io->writeln('Inject data via Messenger');

        $this->dropDatabase($output);
        $this->createDatabase($output);
        $this->createSchema($output);
        $this->setupTransport($output);

        $loader = new NativeLoader($this->generator);
        $objectSet = $loader->loadFile(__DIR__.'/fixtures.yml');


        foreach ($objectSet->getObjects() as $key => $object) {
            $data = '';
            if ($object instanceof IncrementVersion) {
                $data = $object->getVersionType();
            }

            $logger->critical(
                sprintf('Command %s::%s dispatch : %s. ', $key, get_class($object), $data),
                [
                    'data' => (array)$object,
                ]
            );
            $this->messageBus->dispatch($object);
        }

        return 0;
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output): void
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $application->run($input, $output);
    }

    protected function dropDatabase(OutputInterface $output): void
    {
        $this->executeCommand(
            new ArrayInput(
                [
                    'command' => 'doctrine:database:drop',
                    '--force' => true,
                ]
            ),
            $output
        );
    }

    protected function createDatabase(OutputInterface $output): void
    {
        $this->executeCommand(
            new ArrayInput(
                [
                    'command' => 'doctrine:database:create',
                ]
            ),
            $output
        );
    }


    protected function setupTransport(OutputInterface $output): void
    {
        $this->executeCommand(
            new ArrayInput(
                [
                    'command' => 'messenger:setup-transport',
                ]
            ),
            $output
        );
    }

    private function createSchema(OutputInterface $output)
    {
        $this->executeCommand(
            new ArrayInput(
                [
                    'command' => 'doctrine:database:create',
                ]
            ),
            $output
        );
    }
}
