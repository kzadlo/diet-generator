<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

use Doctrine\DBAL\Connection;

class GetPeriodMealIngredientExecutor
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(GetPeriodMealIngredient $getPeriodMealIngredientQuery): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'm.id meal_id',
                'i.weight',
                'i.id ingredient_id',
                'p.name'
            )->from('day', 'd')
            ->join('d', 'meal_to_day', 'mtd', 'd.id = day_id')
            ->join('mtd', 'meal', 'm', 'mtd.meal_id = m.id')
            ->join('m', 'ingredient', 'i', 'm.id = i.meal_id')
            ->join('i', 'product', 'p', 'i.product_id = p.id')
            ->where('d.period_id = :periodId')
            ->setParameter('periodId', $getPeriodMealIngredientQuery->getPeriodId());

        $data = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $periodIngredients = [];
        foreach ($data as $key => $value) {
            $periodIngredients[$value['meal_id']][$value['ingredient_id']] = [
                'weight' => $value['weight'],
                'name' => $value['name']
            ];
        }

        return $periodIngredients;
    }
}
