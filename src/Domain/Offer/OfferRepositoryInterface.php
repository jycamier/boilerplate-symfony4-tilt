<?php

namespace App\Domain\Offer;

interface OfferRepositoryInterface
{
    public function add(Offer $offer): void;
    public function incrementPatchVersion(Offer $offer): void;
    public function incrementMinorVersion(Offer $offer): void;
    public function incrementMajorVersion(Offer $offer): void;
}
