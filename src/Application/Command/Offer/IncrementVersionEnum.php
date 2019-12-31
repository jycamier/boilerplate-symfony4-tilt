<?php

namespace App\Application\Command\Offer;

use MyCLabs\Enum\Enum;

class IncrementVersionEnum extends Enum
{
    private const PATCH = 'patch';
    private const MINOR = 'minor';
    private const MAJOR = 'major';
}
