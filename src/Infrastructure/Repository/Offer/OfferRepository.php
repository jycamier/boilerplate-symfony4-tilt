<?php


namespace App\Infrastructure\Repository\Offer;

use App\Application\Command\Offer\IncrementPatchVersion;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class OfferRepository implements OfferRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private MessageBusInterface $messageBus;

    public function __construct(EntityManagerInterface $entityManager, MessageBusInterface $messageBus)
    {
        $this->entityManager = $entityManager;
        $this->messageBus = $messageBus;
    }

    public function add(Offer $offer): void
    {
        $this->entityManager->persist($offer);
        $this->entityManager->flush();
    }

    public function incrementPatchVersion(string $uuid): void
    {
        $dql = 'UPDATE App\Domain\Offer\Offer o SET o.patchVersion = o.patchVersion + 1 WHERE o.uuid = :uuid';

        $this->incrementVersion($dql, $uuid);
    }

    public function incrementMinorVersion(string $uuid): void
    {
        $dql = 'UPDATE App\Domain\Offer\Offer o SET o.minorVersion = o.minorVersion + 1 WHERE o.uuid = :uuid';

        $this->incrementVersion($dql, $uuid);
    }

    public function incrementMajorVersion(string $uuid): void
    {
        $dql = 'UPDATE App\Domain\Offer\Offer o SET o.majorVersion = o.majorVersion + 1 WHERE o.uuid = :uuid';

        $this->incrementVersion($dql, $uuid);
    }

    protected function incrementVersion(string $dql, string $uuid): void
    {
        $this->entityManager
            ->createQuery($dql)
            ->setParameter('uuid', $uuid)
            ->execute();
    }
}
