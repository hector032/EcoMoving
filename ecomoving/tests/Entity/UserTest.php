<?php


namespace App\Tests\Entity;

use App\Entity\User;

class UserTest extends \PHPUnit\Framework\TestCase
{
    public function testUserEntity(){

        /** @var User $user */
        $user = new User();

        $user->setFirstName('hector');
        $this->assertEquals('hector',$user->getFirstName());

        $user->setLastName('guerra');
        $this->assertEquals('guerra',$user->getLastName());

        $user->setAddress('calle 1');
        $this->assertEquals('calle 1',$user->getAddress());

        $user->setCountry('spain');
        $this->assertEquals('spain',$user->getCountry());

        $user->setCity('madrid');
        $this->assertEquals('madrid',$user->getCity());

        $user->setZipCode(28032);
        $this->assertEquals(28032,$user->getZipCode());

        $user->setPhone(4148756049);
        $this->assertEquals(4148756049,$user->getPhone());

        $user->setStatus(true);
        $this->assertTrue($user->getStatus());
    }

}