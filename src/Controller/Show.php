<?php

namespace App\Controller;

use App\Domain\Review\Review;
use App\Domain\Review\ReviewId;
use App\Domain\Review\ReviewMention;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Show
{
    private ValidatorInterface $validator;
    private NormalizerInterface $normalizer;

    public function __construct(ValidatorInterface $validator, NormalizerInterface $normalizer)
    {
        $this->validator = $validator;
        $this->normalizer = $normalizer;
    }

    public function __invoke()
    {
        return new JsonResponse(
            [
                'ok'
            ]
        );
    }
}
