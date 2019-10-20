<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Day
{
    private $id;

    private $name;

    private $date;

    public function __construct(string $name, \DateTimeInterface $date)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->date = $date;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): Day
    {
        $this->name = $name;
        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function changeDate(\DateTimeInterface $date): Day
    {
        $this->date = $date;
        return $this;
    }
}
