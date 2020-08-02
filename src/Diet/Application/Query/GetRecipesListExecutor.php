<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

use Doctrine\DBAL\Connection;

class GetRecipesListExecutor
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(GetRecipesList $getRecipesListQuery): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'm.id meal_id',
                'm.name',
                'm.calories_quantity',
                'rs.order',
                'rs.description',
                'i.weight',
                'i.id ingredient_id',
                'p.name product_name'
            )->from('meal', 'm')
            ->join('m', 'recipe', 'r', 'm.recipe_id = r.id')
            ->join('r', 'recipe_step', 'rs', 'r.id = rs.recipe_id')
            ->join('m', 'ingredient', 'i', 'm.id = i.meal_id')
            ->join('i', 'product', 'p', 'i.product_id = p.id')
            ->addOrderBy('m.calories_quantity')
            ->addOrderBy('rs.order')
            ->addOrderBy('i.weight', 'DESC')
            ->addOrderBy('m.name')
            ->addOrderBy('p.name')
            ->addOrderBy('rs.description')
            ->addOrderBy('m.id')
            ->addOrderBy('i.id');

        $data = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $recipes = [];
        foreach ($data as $key => $value) {
            $recipes[$value['meal_id']]['mealName'] = $value['name'];
            $recipes[$value['meal_id']]['caloriesQuantity'] = $value['calories_quantity'];
            $recipes[$value['meal_id']]['steps'][$value['order']] = $value['description'];
            $recipes[$value['meal_id']]['ingredients'][$value['product_name']] = $value['weight'];
        }

        return $recipes;
    }
}
