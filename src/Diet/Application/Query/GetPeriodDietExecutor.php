<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

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
            ->select(
                'DATE_FORMAT(d.date, "%d.%m.%Y") date',
                'd.name day_name',
                'm.id meal_id',
                'm.name meal_name',
                'm.calories_quantity'
            )->from('day', 'd')
            ->join('d', 'meal_to_day', 'mtd', 'd.id = day_id')
            ->join('mtd', 'meal', 'm', 'mtd.meal_id = m.id')
            ->where('d.period_id = :periodId')
            ->setParameter('periodId', $getPeriodDietQuery->getPeriodId());

        $data = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $periodDays = [];
        foreach ($data as $key => $value) {
            $periodDays[$value['date']]['dayName'] = $value['day_name'];

            if (!isset($periodDays[$value['date']]['dayCalories'])) {
                $periodDays[$value['date']]['dayCalories'] = 0;
            }

            $periodDays[$value['date']]['dayCalories'] += $value['calories_quantity'];

            $periodDays[$value['date']]['meals'][] = [
                'mealId' => $value['meal_id'],
                'mealName' => $value['meal_name'],
                'caloriesQuantity' => $value['calories_quantity']
            ];
        }

        return $periodDays;
    }
}
