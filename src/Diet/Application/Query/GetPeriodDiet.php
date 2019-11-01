<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

class GetPeriodDiet
{
    private $periodId;

    public function __construct(string $periodId)
    {
        $this->periodId = $periodId;
    }
    public function getPeriodId(): string
    {
        return $this->periodId;
    }
}
