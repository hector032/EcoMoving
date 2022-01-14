<?php


namespace App\Tests\Entity;

use App\Entity\Role;

class RoleTest extends \PHPUnit\Framework\TestCase
{
    public function testGetRole() {

        /** @var Role $role */
        $role = new Role();

        $role->setName('Admin');
        $this->assertEquals('Admin',$role->getName());

        $role->setDescription('Administrador');
        $this->assertEquals('Administrador',$role->getDescription());



    }
}