<?php


namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\IncrementMajorVersion;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class IncrementMajorVersionHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(IncrementMajorVersion $incrementMajorVersion)
    {
        $this->offerRepository->incrementMajorVersion($incrementMajorVersion->getUuid());
    }
}
