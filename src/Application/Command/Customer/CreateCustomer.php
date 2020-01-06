<?php

namespace App\Application\Command\Customer;

use App\Domain\Customer\Customer;

class CreateCustomer
{
    private string $uuid;
    private string $familyName;
    private string $firstName;

    public function __construct(string $uuid, string $familyName, string $firstName)
    {
        $this->uuid = $uuid;
        $this->familyName = $familyName;
        $this->firstName = $firstName;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
}
