<?php

namespace App\Domain\Offer;

use Doctrine\Common\Collections\Collection;

interface OfferRepositoryInterface
{
    public function add(Offer $offer): void;
    public function update(Offer $offer): void;
    public function remove(string $uuid): void;
    public function incrementPatchVersion(string $uuid): void;
    public function incrementMinorVersion(string $uuid): void;
    public function incrementMajorVersion(string $uuid): void;
    public function findAll();
    public function find(string $uuid);
    public function uuidIsUnique(string $uuid): bool;
    public function nameIsUnique(string $name): bool;
    public function getLastVersionOffer();
}
