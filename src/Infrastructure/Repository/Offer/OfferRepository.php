<?php


namespace App\Infrastructure\Repository\Offer;

use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class OfferRepository implements OfferRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Offer $offer): void
    {
        $this->entityManager->persist($offer);
        $this->entityManager->flush();
    }

    public function incrementPatchVersion(Offer $offer): void
    {
        // TODO: Implement incrementMinorVersion() method.
    }

    public function incrementMinorVersion(Offer $offer): void
    {
        // TODO: Implement incrementMinorVersion() method.
    }

    public function incrementMajorVersion(Offer $offer): void
    {
        // TODO: Implement incrementMajorVersion() method.
    }
}
