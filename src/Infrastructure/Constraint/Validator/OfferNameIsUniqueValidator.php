<?php


namespace App\Infrastructure\Constraint\Validator;

use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use App\Domain\Offer\Specifications\OfferNameIsUnique;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Infrastructure\Constraint\OfferNameIsUnique as OfferNameIsUniqueConstraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class OfferNameIsUniqueValidator extends ConstraintValidator implements OfferNameIsUnique
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
        if (!$constraint instanceof OfferNameIsUniqueConstraint) {
            throw new UnexpectedTypeException($constraint, OfferNameIsUniqueConstraint::class);
        }

        if (!$this->isUnique($value->getName()))
        {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isUnique(string $name): bool
    {
        return $this->offerRepository->nameIsUnique($name);
    }
}
