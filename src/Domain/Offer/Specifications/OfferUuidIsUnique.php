<?php

namespace App\Domain\Offer\Specifications;

interface OfferUuidIsUnique
{
    public function isUnique(string $uuid): bool;
}
