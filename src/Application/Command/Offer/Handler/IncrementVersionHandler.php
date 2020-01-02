<?php

namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\CreateFromOffer;
use App\Application\Command\Offer\IncrementVersion;
use App\Application\Command\Offer\IncrementMajorVersion;
use App\Application\Command\Offer\IncrementMinorVersion;
use App\Application\Command\Offer\IncrementPatchVersion;
use App\Application\Command\Offer\IncrementVersionEnum;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Webmozart\Assert\Assert;

class IncrementVersionHandler implements MessageHandlerInterface
{
    private MessageBusInterface $messageBus;
    private OfferRepositoryInterface $offerRepository;

    public function __construct(MessageBusInterface $messageBus, OfferRepositoryInterface $offerRepository)
    {
        $this->messageBus = $messageBus;
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(IncrementVersion $incrementVersion)
    {
        $command = null;
        if ($this->getIncrementVersionEnum($incrementVersion)->equals(IncrementVersionEnum::MINOR())) {
            $command = new IncrementMinorVersion($incrementVersion->getUuid());
        }
        if ($this->getIncrementVersionEnum($incrementVersion)->equals(IncrementVersionEnum::MAJOR())) {
            $offer = $this->offerRepository->find($incrementVersion->getUuid());
            if (null === $offer) {
                throw EntityNotFoundException::fromClassNameAndIdentifier(
                    Offer::class,
                    (array)$incrementVersion->getUuid()
                );
            }
            $command = new CreateFromOffer($offer, Uuid::uuid4()->toString());
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
