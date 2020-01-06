<?php


namespace App\Infrastructure\Repository\Customer;


use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Infrastructure\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class CustomerRepository implements RepositoryInterface, CustomerRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Customer $customer): void
    {
        $this->entityManager->persist($customer);
    }

    public function update(Customer $customer): void
    {
        $this->entityManager->persist($customer);
    }

    public function remove(string $uuid): void
    {
        $dql = 'DELETE FROM App\Domain\Customer\Customer c WHERE c.uuid = :uuid';

        $this->entityManager
            ->createQuery($dql)
            ->setParameter('uuid', $uuid)
            ->execute();
    }

    public function getRepository(): ObjectRepository
    {
        $this->entityManager->getRepository(Customer::class);
    }
}
