<?php


namespace App\Application\Command\Offer;

use App\Domain\Offer\Offer;

class CreateFromOffer
{
    private Offer $offer;
    private ?string $uuid;

    public function __construct(Offer $offer, ?string $uuid = null)
    {
        $this->offer = $offer;
        $this->uuid = $uuid;
    }

    public function getOffer(): Offer
    {
        return $this->offer;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
