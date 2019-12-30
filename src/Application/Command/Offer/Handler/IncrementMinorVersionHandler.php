<?php

namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\IncrementMinorVersion;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class IncrementMinorVersionHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(IncrementMinorVersion $incrementMinorVersion)
    {
        $this->offerRepository->incrementMinorVersion($incrementMinorVersion->getUuid());
    }
}
