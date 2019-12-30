<?php


namespace App\Application\Command\Offer;

use App\Application\SyncMessageInterface;
use Ramsey\Uuid\Uuid;

class CreateOffer implements SyncMessageInterface
{
    private string $name;
    private string $uuid;

    public function __construct(string $name, ?string $uuid = null)
    {
        if (null === $uuid) {
            $uuid = Uuid::uuid4()->toString();
        }
        $this->name = $name;
        $this->uuid = $uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
