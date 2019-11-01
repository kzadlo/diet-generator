<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

use App\Diet\Application\DTO\DayMeal;
use Doctrine\DBAL\Connection;

class GetPeriodDietExecutor
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(GetPeriodDiet $getPeriodDietQuery): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('d.name day_name', 'd.date', 'm.id', 'm.name meal_name', 'm.calories_quantity')
            ->from('day', 'd')
            ->join('d', 'meal_to_day', 'mtd', 'd.id = day_id')
            ->join('mtd', 'meal', 'm', 'mtd.meal_id = m.id')
            ->where('d.period_id = :periodId')
            ->setParameter('periodId', $getPeriodDietQuery->getPeriodId());

        $data = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $periodMeals = [];
        foreach ($data as $dayMeal) {
            $periodMeals[] = new DayMeal(
                $dayMeal['id'],
                $dayMeal['day_name'],
                $dayMeal['date'],
                $dayMeal['meal_name'],
                $dayMeal['calories_quantity']
            );
        }

        return $periodMeals;
    }
}
