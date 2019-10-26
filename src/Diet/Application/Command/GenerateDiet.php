<?php

declare(strict_types=1);

namespace App\Diet\Application\Command;

final class GenerateDiet
{
    private $email;

    private $startDate;

    public function __construct(string $email, string $startDate)
    {
        $this->email = $email;
        $this->startDate = $startDate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }
}
