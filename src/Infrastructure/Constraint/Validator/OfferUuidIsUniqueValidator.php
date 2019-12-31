<?php

namespace App\Infrastructure\Constraint\Validator;

use App\Application\Command\Offer\CreateOffer;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use App\Domain\Offer\Specifications\OfferUuidIsUnique;
use App\Infrastructure\Constraint\OfferUuidIsUnique as OfferUuidIsUniqueConstraint;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class OfferUuidIsUniqueValidator extends ConstraintValidator implements OfferUuidIsUnique
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof Offer) {
            throw new UnexpectedTypeException($value, Offer::class);
        }
        if (!$constraint instanceof OfferUuidIsUniqueConstraint) {
            throw new UnexpectedTypeException($constraint, OfferUuidIsUniqueConstraint::class);
        }

        if (!$this->isUnique($value->getUuid()))
        {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isUnique(string $uuid): bool
    {
        return $this->offerRepository->uuidIsUnique($uuid);
    }
}
