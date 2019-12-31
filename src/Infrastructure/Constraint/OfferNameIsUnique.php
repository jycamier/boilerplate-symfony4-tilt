<?php


namespace App\Infrastructure\Constraint;

use App\Infrastructure\Constraint\Validator\OfferNameIsUniqueValidator;
use Symfony\Component\Validator\Constraint;

class OfferNameIsUnique extends Constraint
{
    public string $message = 'Name already used on another Offer';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy():string
    {
        return OfferNameIsUniqueValidator::class;
    }
}
