<?php


namespace App\Infrastructure\Repository\Offer;

use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use App\Infrastructure\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class OfferRepository implements OfferRepositoryInterface, RepositoryInterface
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
//        $this->entityManager->flush();
    }

    public function incrementPatchVersion(string $uuid): void
    {
        $dql = 'UPDATE App\Domain\Offer\Offer o 
                SET o.patchVersion = o.patchVersion + 1 
                WHERE o.uuid = :uuid';

        $this->incrementVersion($dql, $uuid);
    }

    public function incrementMinorVersion(string $uuid): void
    {
        $dql = 'UPDATE App\Domain\Offer\Offer o 
                SET o.minorVersion = o.minorVersion + 1, o.patchVersion = 0 
                WHERE o.uuid = :uuid';

        $this->incrementVersion($dql, $uuid);
    }

    public function incrementMajorVersion(string $uuid): void
    {
        $dql = 'UPDATE App\Domain\Offer\Offer o 
                SET o.majorVersion = o.majorVersion + 1, o.minorVersion = 0, o.patchVersion = 0
                WHERE o.uuid = :uuid';

        $this->incrementVersion($dql, $uuid);
    }

    protected function incrementVersion(string $dql, string $uuid): void
    {
        $this->entityManager
            ->createQuery($dql)
            ->setParameter('uuid', $uuid)
            ->execute();
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function uuidIsUnique(string $uuid): bool
    {
        return $this->getRepository()->find($uuid) === null;
    }

    public function nameIsUnique(string $name): bool
    {
        return $this->getRepository()->findOneBy(['name' => $name,]) === null;
    }

    public function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Offer::class);
    }
}
