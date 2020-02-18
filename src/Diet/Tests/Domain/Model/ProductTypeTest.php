<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Product;
use App\Diet\Domain\Model\ProductType;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class ProductTypeTest extends TestCase
{
    private $productType;

    protected function setUp(): void
    {
        $this->productType = new ProductType('Product Type Name');
    }

    public function testIsEntityValidAfterCreation(): void
    {
        $this->assertInstanceOf(UuidInterface::class, $this->productType->getId());
        $this->assertSame('Product Type Name', $this->productType->getName());
        $this->assertInstanceOf(Collection::class, $this->productType->getProducts());
        $this->assertEmpty($this->productType->getProducts());
    }

    public function testCanChangeName(): void
    {
        $this->productType->changeName('Product Type Name 2');

        $this->assertSame('Product Type Name 2', $this->productType->getName());
    }

    public function testCanAddDescription(): void
    {
        $this->productType->addDescription('Description for Product Type');

        $this->assertSame('Description for Product Type', $this->productType->getDescription());
    }

    public function testCanRemoveDescription(): void
    {
        $this->productType->addDescription('Description for Product Type');

        $this->assertTrue($this->productType->hasDescription());

        $this->productType->removeDescription();

        $this->expectException(\BadMethodCallException::class);

        $this->productType->getDescription();
    }

    public function testCanAddProduct(): void
    {
        $product = new Product('Product Name');
        $this->productType->addProduct($product);

        $this->assertEquals(1, $this->productType->countProducts());
        $this->assertSame($product->getProductType(), $this->productType);
    }

    public function testCannotAddSameProduct(): void
    {
        $product = new Product('Product Name');
        $this->productType->addProduct($product);
        $this->productType->addProduct($product);

        $this->assertEquals(1, $this->productType->countProducts());
    }

    public function testCanClearProducts(): void
    {
        $this->productType->addProduct(new Product('Product Name'));
        $this->productType->addProduct(new Product('Product Name'));

        $this->assertEquals(2, $this->productType->countProducts());

        $this->productType->clearProducts();

        $this->assertEmpty($this->productType->getProducts());
    }
}
