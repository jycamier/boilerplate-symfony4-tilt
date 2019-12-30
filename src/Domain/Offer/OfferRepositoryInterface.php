<?php

namespace App\Domain\Offer;

interface OfferRepositoryInterface
{
    public function add(Offer $offer): void;
    public function incrementPatchVersion(string $uuid): void;
    public function incrementMinorVersion(string $uuid): void;
    public function incrementMajorVersion(string $uuid): void;
}
