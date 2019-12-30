<?php


namespace App\Controller;

use App\Domain\Review\Review;
use App\Domain\Review\ReviewId;
use App\Domain\Review\ReviewMention;
use Symfony\Component\HttpFoundation\JsonResponse;

class Hello
{
    public function __invoke(int $id)
    {
        return new JsonResponse([
            "show me your tilt {$id} yes yes yes yes yes"
        ]);
    }
}




