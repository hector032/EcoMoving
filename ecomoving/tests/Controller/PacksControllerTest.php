<?php


namespace App\Tests\Controller;
use App\Controller\PacksController;
use App\Entity\Packs;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PacksControllerTest extends WebTestCase
{

    public function testShowPacks()
    {
        $packsEntity = new Packs();
        $packsEntity->setName('packs1');
        $packsEntity->setDescription('packs11');
        $packsEntity->setDuration(2);
        $packsEntity->setPrice(20);
        $packsEntity->setStatus(1);

        $controller = $this->createMock(PacksController::class);
        $controller->method('show')
            ->with($packsEntity)
            ->willReturn(new JsonResponse([
                'name' => $packsEntity->getName(),
                'description' => $packsEntity->getDescription(),
                'duration' => $packsEntity->getDuration(),
                'price' => $packsEntity->getPrice(),
                'status' => $packsEntity->getStatus()
            ], 200));

        $result = $controller->show($packsEntity);

        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('packs1', $content['name']);
        $this->assertEquals('packs11', $content['description']);
        $this->assertEquals(2, $content['duration']);
        $this->assertEquals(20, $content['price']);
        $this->assertEquals(1, $content['status']);
    }

    public function testCreatePacks()
    {
        $request = new Request(['name' => 'pack1', 'description' => 'packs11','duration' => 1,'price' => 20, 'status' => 1]);

        $controller = $this->createMock(PacksController::class);
        $controller->method('create')
            ->with($request)
            ->willReturn(new JsonResponse([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'duration' => $request->get('duration'),
                'price' => $request->get('price'),
                'status' => $request->get('status')
            ], 200));

        $result = $controller->create($request);
        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('pack1', $content['name']);
        $this->assertEquals('packs11', $content['description']);
        $this->assertEquals(1, $content['duration']);
        $this->assertEquals(20, $content['price']);
        $this->assertEquals(1, $content['status']);

    }

    public function testUpdatePacks()
    {

        $packsEntity = new Packs();
        $packsEntity->setName('packs');
        $packsEntity->setDescription('packs');
        $packsEntity->setDuration(5);
        $packsEntity->setPrice(500);
        $packsEntity->setStatus(1);

        $request = new Request(['name' => 'packs1', 'description' => 'packs11', 'duration' => 2, 'price' => 50, 'status' => 1]);

        $controller = $this->createMock(PacksController::class);
        $controller->method('edit')
            ->with($request)
            ->willReturn(new JsonResponse([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'duration' => $request->get('duration'),
                'price' => $request->get('price'),
                'status' => $request->get('status')
            ], 200));

        $result = $controller->edit($request, $packsEntity);
        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('packs1', $content['name']);
        $this->assertEquals('packs11', $content['description']);
        $this->assertEquals(2, $content['duration']);
        $this->assertEquals(50, $content['price']);
        $this->assertEquals(1, $content['status']);
    }

    public function testDeletePacks()
    {
        $categoryEntity = new Packs();

        $categoryEntity->setName('packs');
        $categoryEntity->setDescription('packs1');
        $categoryEntity->setDuration(10);
        $categoryEntity->setPrice(50);
        $categoryEntity->setStatus(0);

        $controller = $this->createMock(PacksController::class);
        $controller->method('delete')
            ->with($categoryEntity)
            ->willReturn(new JsonResponse([], 204));

        $result = $controller->delete($categoryEntity);

        $this->assertEquals(204,$result->getStatusCode());
    }
}