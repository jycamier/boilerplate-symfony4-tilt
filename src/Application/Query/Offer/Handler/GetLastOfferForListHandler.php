<?php

namespace App\Application\Query\Offer\Handler;

use App\Application\Query\Offer\GetLastOfferForList;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetLastOfferForListHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(GetLastOfferForList $getLastOfferForList)
    {
        return $this->offerRepository->getLastVersionOffer();
    }
}
