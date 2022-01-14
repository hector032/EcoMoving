<?php


namespace App\Tests\Controller;


use App\Controller\ProductController;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductControllerTest extends WebTestCase
{
    public function testShowProduct()
    {
        $productEntiy = new Product();
        $productEntiy->setName('hector');
        $productEntiy->setDescription('hola como estas');
        $productEntiy->setStatus(1);

        $controller = $this->createMock(ProductController::class);
        $controller->method('show')
            ->with($productEntiy)
            ->willReturn(new JsonResponse([
                'name' => $productEntiy->getName(),
                'description' => $productEntiy->getDescription(),
                'status' => $productEntiy->getStatus(),


            ], 200));

        $result = $controller->show($productEntiy);

        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('hector', $content['name']);
        $this->assertEquals('hola como estas', $content['description']);
        $this->assertEquals(1, $content['status']);

    }


    public function testCreateProduct()
    {
        $request = new Request(['name' => 'guantes', 'description' => 'guantes para bicicletas', 'status' => 1]);

        $controller = $this->createMock(ProductController::class);
        $controller->method('create')
            ->with($request)
            ->willReturn(new JsonResponse([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'status' => $request->get('status')
            ], 200));

        $result = $controller->create($request);
        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('guantes', $content['name']);
        $this->assertEquals('guantes para bicicletas', $content['description']);
        $this->assertEquals(1, $content['status']);

    }

    public function testUpdateProduct()
    {

        $productEntity = new Product();
        $productEntity->setName('guantes');
        $productEntity->setDescription('guantes para bicicletas');
        $productEntity->setStatus(1);

        $request = new Request(['name' => 'cascos', 'description' => 'cascos para bicicletas', 'status' => 1]);

        $controller = $this->createMock(ProductController::class);
        $controller->method('edit')
            ->with($request)
            ->willReturn(new JsonResponse([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'status' => $request->get('status')
            ], 200));

        $result = $controller->edit($request, $productEntity);
        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('cascos', $content['name']);
        $this->assertEquals('cascos para bicicletas', $content['description']);
        $this->assertEquals(1, $content['status']);
    }

    public function testDeleteCategory()
    {
        $productEntity = new Product();

        $productEntity->setName('cascos');
        $productEntity->setDescription('cascos para bicicletas');
        $productEntity->setStatus(0);

        $controller = $this->createMock(ProductController::class);
        $controller->method('delete')
            ->with($productEntity)
            ->willReturn(new JsonResponse([], 204));

        $result = $controller->delete($productEntity);

        $this->assertEquals(204,$result->getStatusCode());
    }
}