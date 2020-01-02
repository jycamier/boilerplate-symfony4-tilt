<?php


namespace App\Application\Command\Offer\Handler;

use App\Application\Command\Offer\CreateOffer;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function count;

class CreateOfferHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;
    private ValidatorInterface $validator;

    public function __construct(OfferRepositoryInterface $offerRepository, ValidatorInterface $validator)
    {
        $this->offerRepository = $offerRepository;
        $this->validator = $validator;
    }

    public function __invoke(CreateOffer $createOffer)
    {
        $offer = Offer::create($createOffer->getUuid(), $createOffer->getName());
        $violations = $this->validator->validate($offer);
        if ($violations && count($violations)) {
            throw new ValidationFailedException($createOffer, $violations);
        }
        $this->offerRepository->add($offer);
    }
}
