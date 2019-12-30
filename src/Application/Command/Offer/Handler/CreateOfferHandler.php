<?php


namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\CreateOffer;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOfferHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(CreateOffer $createOffer)
    {
        $offer = Offer::create($createOffer->getUuid(), $createOffer->getName());
        $this->offerRepository->add($offer);
    }
}
