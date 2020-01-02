<?php

namespace App\Domain\Offer;

use Cocur\Slugify\Slugify;
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

    public static function createFromOffer(string $uuid, Offer $offer): Offer
    {
        return new self(
            $uuid,
            $offer->getName(),
            $offer->getPatchVersion(),
            $offer->getMinorVersion(),
            $offer->getMajorVersion(),
            $offer
        );
    }

    private string $uuid;
    private string $name;
    private string $slug;
    private int $patchVersion;
    private int $minorVersion;
    private int $majorVersion;
    private bool $lastVersion = true;
    private ?Offer $previousMajorVersion;

    protected function __construct(
        string $uuid,
        string $name,
        int $patchVersion = 0,
        int $minorVersion = 0,
        int $majorVersion = 0,
        ?Offer $previousMajorVersion = null
    ) {
        Assert::uuid($uuid);

        $this->uuid = $uuid;
        $this->name = $name;
        $this->patchVersion = $patchVersion;
        $this->minorVersion = $minorVersion;
        $this->majorVersion = $majorVersion;
        $this->previousMajorVersion = $previousMajorVersion;
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

    public function setLastVersion(bool $lastVersion): void
    {
        $this->lastVersion = $lastVersion;
    }

    public function isLastVersion(): bool
    {
        return $this->lastVersion;
    }

    public function __toString(): string
    {
        return "{$this->name}[{$this->uuid}]";
    }

    public function getPreviousMajorVersion(): ?Offer
    {
        return $this->previousMajorVersion;
    }
}
