<?php


namespace App\Domain\Customer;

class Customer
{
    public static function create(string $uuid, string $familyName, string $firstName): self
    {
        return new self($uuid, $familyName, $firstName);
    }

    private string $uuid;
    private string $familyName;
    private string $firstName;

    protected function __construct(string $uuid, string $familyName, string $firstName)
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
