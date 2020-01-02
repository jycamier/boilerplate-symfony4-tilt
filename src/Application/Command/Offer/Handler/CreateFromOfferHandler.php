<?php

namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\CreateFromOffer;
use App\Application\Command\Offer\IncrementMajorVersion;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Webmozart\Assert\Assert;

class CreateFromOfferHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;
    private MessageBusInterface $messageBus;

    public function __construct(OfferRepositoryInterface $offerRepository, MessageBusInterface $messageBus)
    {
        $this->offerRepository = $offerRepository;
        $this->messageBus = $messageBus;
    }

    public function __invoke(CreateFromOffer $createFromOffer)
    {
        $originalOffer = $createFromOffer->getOffer();

        Assert::true(
            $originalOffer->isLastVersion(),
            sprintf(
                'Cannot create a new major version of "%s:%s". it\'s not the last version',
                $originalOffer->getName(),
                $originalOffer->getUuid()
            )
        );

        $offer = Offer::createFromOffer($createFromOffer->getUuid(), $originalOffer);
        $this->offerRepository->add($offer);

        $originalOffer->setLastVersion(false);
        $this->offerRepository->update($originalOffer);

        $this->messageBus->dispatch(
            (new Envelope(new IncrementMajorVersion($offer->getUuid())))->with(new DispatchAfterCurrentBusStamp())
        );
    }
}
