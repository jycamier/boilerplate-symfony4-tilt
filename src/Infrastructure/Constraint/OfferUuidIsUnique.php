<?php


namespace App\Infrastructure\Constraint;

use App\Infrastructure\Constraint\Validator\OfferUuidIsUniqueValidator;
use Symfony\Component\Validator\Constraint;

class OfferUuidIsUnique extends Constraint
{
    public string $message = 'UUID already used on another Offer';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return OfferUuidIsUniqueValidator::class;
    }
}
