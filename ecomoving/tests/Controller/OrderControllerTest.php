<?php


namespace App\Tests\Controller;


use App\Controller\OrderController;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderControllerTest extends WebTestCase
{

    public function testShowOrder()
    {
        $orderEntity = new Order();
        $orderEntity->setProduct(1);
        $orderEntity->setPacks(1);
        $orderEntity->setUser(1);
        $orderEntity->setStatus(1);

        $controller = $this->createMock(OrderController::class);
        $controller->method('show')
            ->with($orderEntity)
            ->willReturn(new JsonResponse([
                'product_id' => $orderEntity->getProduct(),
                'packs_id' => $orderEntity->getPacks(),
                'user_id' => $orderEntity->getUser(),
                'status' => $orderEntity->getStatus()
            ], 200));

        $result = $controller->show($orderEntity);

        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals(1, $content['product_id']);
        $this->assertEquals(1, $content['packs_id']);
        $this->assertEquals(1, $content['user_id']);
        $this->assertEquals(1, $content['status']);
    }

    public function testCreateOrder()
    {
        $request = new Request(['product_id' => 1, 'packs_id' => 1,'user_id' => 1, 'status' => 1]);

        $controller = $this->createMock(OrderController::class);
        $controller->method('create')
            ->with($request)
            ->willReturn(new JsonResponse([
                'product_id' => $request->get('product_id'),
                'packs_id' => $request->get('packs_id'),
                'user_id' => $request->get('user_id'),
                'status' => $request->get('status')
            ], 200));

        $result = $controller->create($request);
        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals(1, $content['product_id']);
        $this->assertEquals(1, $content['packs_id']);
        $this->assertEquals(1, $content['user_id']);
        $this->assertEquals(1, $content['status']);

    }

    public function testUpdateOrder()
    {

        $orderEntity = new Order();
        $orderEntity->setUser(1);
        $orderEntity->setPacks(1);
        $orderEntity->setProduct(1);
        $orderEntity->setStatus(1);

        $request = new Request(['product_id' => 1, 'packs_id' => 1,'user_id' => 1, 'status' => 1]);

        $controller = $this->createMock(OrderController::class);
        $controller->method('edit')
            ->with($request)
            ->willReturn(new JsonResponse([
                'product_id' => $request->get('product_id'),
                'packs_id' => $request->get('packs_id'),
                'user_id' => $request->get('user_id'),
                'status' => $request->get('status')
            ], 200));

        $result = $controller->edit($request, $orderEntity);
        $content = \json_decode($result->getContent(), true);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals(1, $content['product_id']);
        $this->assertEquals(1, $content['packs_id']);
        $this->assertEquals(1, $content['user_id']);
        $this->assertEquals(1, $content['status']);
    }

    public function testDeleteOrder()
    {
        $orderEntity = new Order();

        $orderEntity->setUser(1);
        $orderEntity->setPacks(1);
        $orderEntity->setProduct(1);
        $orderEntity->setStatus(1);

        $controller = $this->createMock(OrderController::class);
        $controller->method('delete')
            ->with($orderEntity)
            ->willReturn(new JsonResponse([], 204));

        $result = $controller->delete($orderEntity);

        $this->assertEquals(204,$result->getStatusCode());
    }
}

