<?php


namespace App\Tests\Controller;


use App\Controller\CategoryController;
use App\Entity\Category;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class CategoryControllerTest extends WebTestCase
{
    public function testShowCategory()
    {
        $categoryEntity = new Category();
        $categoryEntity->setName('accesorios');
        $categoryEntity->setDescription('accesorios para bicicletas');
        $categoryEntity->setStatus(1);

        $controller = $this->createMock(CategoryController::class);
        $controller->method('show')
            ->with($categoryEntity)
            ->willReturn(new JsonResponse([
                'name' => $categoryEntity->getName(),
                'description' => $categoryEntity->getDescription(),
                'status' => $categoryEntity->getStatus()
            ], 200));

        $result = $controller->show($categoryEntity);

        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('accesorios', $content['name']);
        $this->assertEquals('accesorios para bicicletas', $content['description']);
        $this->assertEquals(1, $content['status']);
    }

    public function testCreateCategory()
    {
        $request = new Request(['name' => 'guantes', 'description' => 'guantes para bicicletas', 'status' => 1]);

        $controller = $this->createMock(CategoryController::class);
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

    public function testUpdateCategory()
    {

        $categoryEntity = new Category();
        $categoryEntity->setName('guantes');
        $categoryEntity->setDescription('guantes para bicicletas');
        $categoryEntity->setStatus(1);

        $request = new Request(['name' => 'cascos', 'description' => 'cascos para bicicletas', 'status' => 1]);

        $controller = $this->createMock(CategoryController::class);
        $controller->method('edit')
            ->with($request)
            ->willReturn(new JsonResponse([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'status' => $request->get('status')
            ], 200));

        $result = $controller->edit($request, $categoryEntity);
        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('cascos', $content['name']);
        $this->assertEquals('cascos para bicicletas', $content['description']);
        $this->assertEquals(1, $content['status']);
    }

    public function testDeleteCategory()
    {
        $categoryEntity = new Category();

        $categoryEntity->setName('cascos');
        $categoryEntity->setDescription('cascos para bicicletas');
        $categoryEntity->setStatus(0);

        $controller = $this->createMock(CategoryController::class);
        $controller->method('delete')
            ->with($categoryEntity)
            ->willReturn(new JsonResponse([], 204));

        $result = $controller->delete($categoryEntity);

        $this->assertEquals(204,$result->getStatusCode());
    }
}