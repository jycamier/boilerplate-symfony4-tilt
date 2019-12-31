<?php

namespace App\Infrastructure\Repository;

use Doctrine\Persistence\ObjectRepository;

interface RepositoryInterface
{
    public function getRepository(): ObjectRepository;
}
