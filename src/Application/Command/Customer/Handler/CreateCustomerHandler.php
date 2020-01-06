<?php


namespace App\Application\Command\Customer\Handler;

use App\Application\Command\Customer\CreateCustomer;
use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCustomerHandler implements MessageHandlerInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke(CreateCustomer $createCustomer)
    {
        $customer = Customer::create(
            $createCustomer->getUuid(),
            $createCustomer->getFamilyName(),
            $createCustomer->getFirstName()
        );
        $this->customerRepository->add($customer);
    }
}
