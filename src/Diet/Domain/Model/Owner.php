<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Owner
{
    private $id;

    private $email;

    private $firstName;

    private $lastName;

    private $birthDate;

    private $bodyMeasurement;

    public function __construct(string $email, \DateTime $birthDate, BodyMeasurement $bodyMeasurement)
    {
        $this->id = Uuid::uuid4();
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->bodyMeasurement = $bodyMeasurement;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function changeEmail(string $email): Owner
    {
        $this->email = $email;
        return $this;
    }

    public function getBodyMeasurement(): BodyMeasurement
    {
        return $this->bodyMeasurement;
    }

    public function changeBodyMeasurement(BodyMeasurement $bodyMeasurement): Owner
    {
        $this->bodyMeasurement = $bodyMeasurement;
        return $this;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getAge(): int
    {
        return $this->birthDate
            ->diff(new \DateTime())
            ->y;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Owner
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Owner
    {
        $this->lastName = $lastName;
        return $this;
    }
}
