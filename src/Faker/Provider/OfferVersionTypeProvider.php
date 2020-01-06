<?php


namespace App\Faker\Provider;

use App\Application\Command\Offer\IncrementVersionEnum;
use Faker\Provider\Base;

class OfferVersionTypeProvider extends Base
{
    public static function versionTypeNotMajor()
    {
        $values = [
            new IncrementVersionEnum(IncrementVersionEnum::PATCH()),
            new IncrementVersionEnum(IncrementVersionEnum::MINOR()),
        ];
        return self::randomElement($values)->getValue();
    }

    public static function versionTypeMajor()
    {
        $values = [
            new IncrementVersionEnum(IncrementVersionEnum::MAJOR()),
        ];
        return self::randomElement($values)->getValue();
    }
}
