<?php


namespace App\Domain\Customer;

interface CustomerRepositoryInterface
{
    public function add(Customer $customer): void;
    public function update(Customer $customer): void;
    public function remove(string $uuid): void;
}
