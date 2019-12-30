<?php


namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\IncrementPatchVersion;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class IncrementPatchVersionHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(IncrementPatchVersion $incrementPatchVersion)
    {
        $this->offerRepository->incrementPatchVersion($incrementPatchVersion->getUuid());
    }
}
