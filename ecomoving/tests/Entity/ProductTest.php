<?php


namespace App\Tests\Entity;



use App\Entity\Product;

class ProductTest extends \PHPUnit\Framework\TestCase
{

    public function testGetProduct() {

        /** @var Product $product */
        $product = new Product();

        $product->setName('guantes');
        $this->assertEquals('guantes',$product->getName());

        $product->setDescription('guantes muy grandes y comodos');
        $this->assertEquals('guantes muy grandes y comodos',$product->getDescription());

        $product->setStatus(true);
        $this->assertEquals(true,$product->getStatus());


    }
}