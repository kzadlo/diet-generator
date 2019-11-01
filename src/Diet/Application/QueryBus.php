<?php

declare(strict_types=1);

namespace App\Diet\Application;

use App\Diet\Application\Exception\QueryExecutorNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class QueryBus
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function dispatch(object $query)
    {
        $executorName = get_class($query) . 'Executor';

        if (!$this->container->has($executorName)) {
            throw new QueryExecutorNotFoundException($executorName . ' does not exist!');
        }

        $executor = $this->container->get($executorName);

        return $executor->execute($query);
    }
}
