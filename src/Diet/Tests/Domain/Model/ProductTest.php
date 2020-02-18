<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Product;
use App\Diet\Domain\Model\ProductType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class ProductTest extends TestCase
{
    private $product;

    protected function setUp(): void
    {
        $this->product = new Product('Product Name');
    }

    public function testIsEntityValidAfterCreation(): void
    {
        $this->assertInstanceOf(UuidInterface::class, $this->product->getId());
        $this->assertSame('Product Name', $this->product->getName());
    }

    public function testCanChangeName(): void
    {
        $this->product->changeName('Product Name 2');

        $this->assertSame('Product Name 2', $this->product->getName());
    }

    public function testCanSetProductType(): void
    {
        $productType = new ProductType('Type Name');
        $this->product->setProductType($productType);

        $this->assertEquals($productType, $this->product->getProductType());
    }
}
