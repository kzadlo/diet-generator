<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DietPlan
{
    private $id;

    private $dietType;

    public function __construct(DietType $dietType)
    {
        $this->id = Uuid::uuid4();
        $this->dietType = $dietType;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getType(): DietType
    {
        return $this->dietType;
    }

    public function changeType(DietType $dietType): DietPlan
    {
        $this->dietType = $dietType;
        return $this;
    }
}
