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
    private int $patchVersion = 0;
    private int $minorVersion = 0;
    private int $majorVersion = 0;

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

    public function getPatchVersion(): int
    {
        return $this->patchVersion;
    }

    public function getMinorVersion(): int
    {
        return $this->minorVersion;
    }

    public function getMajorVersion(): int
    {
        return $this->majorVersion;
    }
}
