<?php


namespace App\Tests\Entity;


use App\Entity\Order;
use App\Entity\Packs;

class OrderTest extends \PHPUnit\Framework\TestCase
{


    public function testGetOrder(){

        /** @var Order $order */
        $order = new Order();

        $order->setUser(1);
        $this->assertEquals(1,$order->getUser());

        $order->setPacks(1);
        $this->assertEquals(1,$order->getPacks());

        $order->setProduct(1);
        $this->assertEquals(1,$order->getProduct());

        $order->setStatus(true);
        $this->assertEquals(true,$order->getStatus());
    }

}