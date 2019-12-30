<?php


namespace App\UI\Console\Offer;

use App\Application\Command\Offer\IncrementMajorVersion;
use App\Application\Command\Offer\IncrementMinorVersion;
use App\Application\Command\Offer\IncrementPatchVersion;
use App\UI\Common\IncrementVersionEnum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

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
        $version = $input->getArgument('version');
        Assert::true(
            IncrementVersionEnum::isValid($version),
            "The version type '{$version}' is not in the awaited list"
        );

        $output->writeln('Increment of an offer...');

        $command = null;
        switch ($input->getArgument('version')){
            case IncrementVersionEnum::MINOR():
                $command = new IncrementMinorVersion($input->getArgument('uuid'));
                break;
            case IncrementVersionEnum::MAJOR():
                $command = new IncrementMajorVersion($input->getArgument('uuid'));
                break;
            case IncrementVersionEnum::PATCH():
            default:
                $command = new IncrementPatchVersion($input->getArgument('uuid'));

        }
        
        $this->messageBus->dispatch($command);

        return 0;
    }
}
