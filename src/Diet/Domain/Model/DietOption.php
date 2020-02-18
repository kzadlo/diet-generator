<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DietOption
{
    public const NOT_EAT_MEAT_FRIDAY = 0;

    public const EAT_MEAT_FRIDAY = 1;

    private $id;

    private $hasMeatFriday;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->hasMeatFriday = self::NOT_EAT_MEAT_FRIDAY;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function hasMeatFriday(): bool
    {
        return (bool) $this->hasMeatFriday;
    }

    public function activateMeatFriday(): void
    {
        $this->hasMeatFriday = self::EAT_MEAT_FRIDAY;
    }

    public function deactivateMeatFriday(): void
    {
        $this->hasMeatFriday = self::NOT_EAT_MEAT_FRIDAY;
    }
}
