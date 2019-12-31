<?php

namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\IncrementVersion;
use App\Application\Command\Offer\IncrementMajorVersion;
use App\Application\Command\Offer\IncrementMinorVersion;
use App\Application\Command\Offer\IncrementPatchVersion;
use App\Application\Command\Offer\IncrementVersionEnum;
use InvalidArgumentException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Webmozart\Assert\Assert;

class IncrementVersionHandler implements MessageHandlerInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(IncrementVersion $incrementVersion)
    {
        $command = null;
        if ($this->getIncrementVersionEnum($incrementVersion)->equals(IncrementVersionEnum::MINOR())) {
            $command = new IncrementMinorVersion($incrementVersion->getUuid());
        }
        if ($this->getIncrementVersionEnum($incrementVersion)->equals(IncrementVersionEnum::MAJOR())) {
            $command = new IncrementMajorVersion($incrementVersion->getUuid());
        }
        if ($this->getIncrementVersionEnum($incrementVersion)->equals(IncrementVersionEnum::PATCH())) {
            $command = new IncrementPatchVersion($incrementVersion->getUuid());
        }

        if (null === $command) {
            throw new InvalidArgumentException(
                'No command associated with '.$incrementVersion->getVersionType()->getValue()
            );
        }

        $this->messageBus->dispatch((new Envelope($command))->with(new DispatchAfterCurrentBusStamp()));
    }

    protected function getIncrementVersionEnum(IncrementVersion $incrementVersion): IncrementVersionEnum
    {
        return new IncrementVersionEnum($incrementVersion->getVersionType());
    }
}
