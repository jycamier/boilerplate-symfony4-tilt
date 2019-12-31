<?php

namespace App\Application\Command\Offer;

use App\Application\SyncMessageInterface;
use Webmozart\Assert\Assert;

class IncrementVersion implements SyncMessageInterface
{
    private string $versionType;
    private string $uuid;

    public function __construct(string $versionType, string $uuid)
    {
        Assert::true(
            IncrementVersionEnum::isValid($versionType),
            "The version type '{$versionType}' is not in the awaited list"
        );
        $this->versionType = $versionType;
        $this->uuid = $uuid;
    }

    public function getVersionType(): string
    {
        return $this->versionType;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
