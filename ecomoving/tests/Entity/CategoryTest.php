<?php


namespace App\Tests\Entity;

use App\Entity\Category;

class CategoryTest extends \PHPUnit\Framework\TestCase
{

    public function testGetCategory(){

        /** @var Category $category */
        $category = new Category();

        $category->setName('accesorios');
        $this->assertEquals('accesorios',$category->getName());

        $category->setDescription('accesorios de calidad');
        $this->assertEquals('accesorios de calidad',$category->getDescription());

        $category->setStatus(true);
        $this->assertEquals(true,$category->getStatus());
    }
}