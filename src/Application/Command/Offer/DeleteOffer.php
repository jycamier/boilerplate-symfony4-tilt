<?php


namespace App\Application\Command\Offer;

use App\Application\SyncMessageInterface;

class DeleteOffer implements SyncMessageInterface
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

}
