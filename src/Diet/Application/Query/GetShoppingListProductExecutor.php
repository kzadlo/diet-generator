<?php

declare(strict_types=1);

namespace App\Diet\Application\Query;

use Doctrine\DBAL\Connection;

class GetShoppingListProductExecutor
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(GetShoppingListProduct $getShoppingListProduct): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'p.name product_name',
                'SUM(i.weight) weight',
                'pt.name product_type_name'
            )->from('ingredient', 'i')
            ->join('i', 'product', 'p', 'i.product_id = p.id')
            ->join('p', 'product_type', 'pt', 'p.product_type_id = pt.id')
            ->join('i', 'meal', 'm', 'i.meal_id = m.id')
            ->join('m', 'meal_to_day', 'mtd', 'm.id = mtd.meal_id')
            ->join('mtd', 'day', 'd', 'mtd.day_id = d.id')
            ->where('d.date BETWEEN :startDate AND :endDate')
            ->groupBy('p.id')
            ->orderBy('product_name')
            ->setParameter('startDate', $getShoppingListProduct->getStartDate())
            ->setParameter('endDate', $getShoppingListProduct->getEndDate());

        $data = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        $products = [];
        foreach ($data as $key => $value) {
            $products[$value['product_type_name']][] = [
                'name' => $value['product_name'],
                'weight' => $value['weight']
            ];
        }

        return $products;
    }
}
