<?php


namespace App\Tests\Controller;


use App\Controller\UserController;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserControllerTest extends WebTestCase
{

    public function testShowUser()
    {
        $userEntity = new Users();
        $userEntity->setFirstName('hector');
        $userEntity->setLastName('guerra');
        $userEntity->setAddress('callejero');
        $userEntity->setCountry('spain');
        $userEntity->setCity('madrid');
        $userEntity->setZipCode(28056);
        $userEntity->setPhone(619674484);
        $userEntity->setStatus(1);

        $controller = $this->createMock(UserController::class);
        $controller->method('show')
            ->with($userEntity)
            ->willReturn(new JsonResponse([
                'firstName' => $userEntity->getFirstName(),
                'lastName' => $userEntity->getLastName(),
                'address' => $userEntity->getAddress(),
                'country' => $userEntity->getCountry(),
                'city' => $userEntity->getCity(),
                'zip_code' => $userEntity->getZipCode(),
                'phone' => $userEntity->getPhone(),
                'status' => $userEntity->getStatus(),

            ], 200));

        $result = $controller->show($userEntity);

        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('hector', $content['firstName']);
        $this->assertEquals('guerra', $content['lastName']);
        $this->assertEquals('callejero', $content['address']);
        $this->assertEquals('spain', $content['country']);
        $this->assertEquals('madrid', $content['city']);
        $this->assertEquals(28056, $content['zip_code']);
        $this->assertEquals(619674484, $content['phone']);
        $this->assertEquals(1, $content['status']);

    }

    /*public function testCreateUser(){}
    public function testDeleteUser(){}
    public function testUpdateser(){}*/

}