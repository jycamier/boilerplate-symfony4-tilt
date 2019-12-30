<?php

namespace App\Domain\Offer;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Offer
{
    public static function create(string $uuid, string $name): Offer
    {
        return new self($uuid, $name);
    }

    private string $uuid;
    private string $name;

    protected function __construct(string $uuid, string $name)
    {
        Assert::uuid($uuid);

        $this->uuid = $uuid;
        $this->name = $name;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
