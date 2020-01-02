<?php

namespace App\Application\Query\Offer\DTO;

class LastVersionOffer
{
    private string $uuid;
    private string $name;
    private string $majorVersion;
    private string $minorVersion;
    private string $patchVersion;

    public function __construct(string $uuid, string $name, string $majorVersion, string $minorVersion, string $patchVersion)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->majorVersion = $majorVersion;
        $this->minorVersion = $minorVersion;
        $this->patchVersion = $patchVersion;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return implode(
            '.',
            [
                $this->majorVersion,
                $this->minorVersion,
                $this->patchVersion,
            ]
        );
    }
}
