<?php


namespace App\Domain\Offer\Specifications;

interface OfferNameIsUnique
{
    public function isUnique(string $name): bool;
}
