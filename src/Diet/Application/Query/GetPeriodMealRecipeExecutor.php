<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

use Doctrine\DBAL\Connection;

class GetPeriodMealRecipeExecutor
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(GetPeriodMealRecipe $getPeriodMealRecipeQuery): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'm.id meal_id',
                'rs.order',
                'rs.description'
            )->from('day', 'd')
            ->join('d', 'meal_to_day', 'mtd', 'd.id = day_id')
            ->join('mtd', 'meal', 'm', 'mtd.meal_id = m.id')
            ->join('m', 'recipe', 'r', 'm.recipe_id = r.id')
            ->join('r', 'recipe_step', 'rs', 'r.id = rs.recipe_id')
            ->andWhere('d.period_id = :periodId')
            ->addGroupBy('rs.id')
            ->addGroupBy('rs.order')
            ->addGroupBy('m.id')
            ->addOrderBy('rs.order')
            ->setParameter('periodId', $getPeriodMealRecipeQuery->getPeriodId());

        $data = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $periodRecipes = [];
        foreach ($data as $key => $value) {
            $periodRecipes[$value['meal_id']][$value['order']] = $value['description'];
        }

        return $periodRecipes;
    }
}
