<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ProductType
{
    private $id;

    private $name;

    private $description;

    private $products;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->products = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): ProductType
    {
        $this->name = $name;
        return $this;
    }

    public function addDescription(string $description): ProductType
    {
        $this->description = $description;
        return $this;
    }

    public function removeDescription(): ProductType
    {
        $this->description = null;
        return $this;
    }

    public function getDescription(): string
    {
        if (!$this->hasDescription()) {
            throw new \BadMethodCallException();
        }

        return $this->description;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): ProductType
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setProductType($this);
        }
        return $this;
    }

    public function countProducts(): int
    {
        return $this->products->count();
    }

    public function clearProducts(): ProductType
    {
        $this->products->clear();
        return $this;
    }
}
