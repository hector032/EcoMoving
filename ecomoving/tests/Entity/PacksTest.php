<?php


namespace App\Tests\Entity;

use App\Entity\Packs;

class PacksTest extends \PHPUnit\Framework\TestCase
{

    public function testGetPacks(){

        /** @var Packs $packs */
        $packs = new Packs();

        $packs->setName('accesorios');
        $this->assertEquals('accesorios',$packs->getName());

        $packs->setDescription('accesorios de calidad');
        $this->assertEquals('accesorios de calidad',$packs->getDescription());

        $packs->setDuration(1);
        $this->assertEquals(1,$packs->getDuration());

        $packs->setPrice(10);
        $this->assertEquals(10,$packs->getPrice());

        $packs->setStatus(true);
        $this->assertEquals(true,$packs->getStatus());
    }
}