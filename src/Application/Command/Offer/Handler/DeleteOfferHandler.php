<?php


namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\DeleteOffer;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteOfferHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(DeleteOffer $deleteOffer)
    {
        $this->offerRepository->remove($deleteOffer->getUuid());
    }
}
