<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

use App\Diet\Application\Service\DayNameTranslator;
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
            ->orderBy('d.date')
            ->setParameter('periodId', $getPeriodDietQuery->getPeriodId());

        $data = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $periodDays = [];
        foreach ($data as $day) {
            $periodDays[$day['date']]['dayName'] = DayNameTranslator::map($day['day_name']);
            $periodDays[$day['date']]['date'] = $day['date'];

            if (!isset($periodDays[$day['date']]['caloriesQuantity'])) {
                $periodDays[$day['date']]['caloriesQuantity'] = 0;
            }

            $periodDays[$day['date']]['caloriesQuantity'] += $day['calories_quantity'];

            $periodDays[$day['date']]['meals'][] = [
                'mealId' => $day['meal_id'],
                'mealName' => $day['meal_name'],
                'caloriesQuantity' => $day['calories_quantity']
            ];
        }

        return $periodDays;
    }
}
