<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\Packs;
use App\Entity\Product;
use App\Entity\Users;
use App\Form\OrderType;
use App\Input\OrderInput;
use App\Repository\OrderRepository;
use App\Repository\PacksRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/order")
 */
class OrderController extends AbstractController
{

    /**
     * @Route("/list", name="order_list", methods={"GET"})
     */
    public function list(OrderRepository $orderRepository, PaginatorInterface $paginator, Request $request): Response
    {

        //TODO: its need apply limti in this query
        $orders = $orderRepository->findAll();

        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 500;

        $results = $paginator->paginate($orders, $page, $limit);

        $items = [];

        /** @var Order $order */
        foreach ($results->getItems() as $order) {
            $items[] = [
                'id' => $order->getId(),
                'user_id' => $order->getUser()->getId(),
                'packs_id' => $order->getPacks()->getId(),
                'status' => $order->getStatus(),
                'product_id' => $order->getProduct()->getId()
            ];
        }

        $output = [
            'items' => $items,
            'total' => $results->getTotalItemCount()
        ];

        return new JsonResponse($output);
    }

    /**
     * @Route("/create", name="order_create",  methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        try {

            $requestData = \json_decode($request->getContent(), true);

            $request->request->set('user_id', $requestData['user_id']);
            $request->request->set('packs_id', $requestData['packs_id']);
            $request->request->set('product_id', $requestData['product_id']);
            $request->request->set('status', $requestData['status']);

            OrderType::setMethod('POST');

            $form = $this->createForm(OrderType::class, new OrderInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var OrderInput $data */
                $data = $form->getData();

                /** @var Order $order */
                $order = new Order();

                $userRepository = $this->getDoctrine()->getRepository(Users::class);
                /** @var UserRepository $user */
                $user = $userRepository->find($requestData['user_id']);

                $packsRepository = $this->getDoctrine()->getRepository(Packs::class);
                /** @var PacksRepository $packs */
                $packs = $packsRepository->find($requestData['packs_id']);

                $productRepository = $this->getDoctrine()->getRepository(Product::class);
                /** @var ProductRepository $product */
                $product = $productRepository->find($requestData['product_id']);


                $order->setUser($user);
                $order->setProduct($product);
                $order->setPacks($packs);
                $order->setStatus($data->getStatus());
                $order->setCreatedAt(new \DateTime());


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($order);
                $entityManager->flush();

                return new JsonResponse(['sucess' => 'ok!']);

            } else {
                return new JsonResponse(['Error, valores no permitidos'], 400);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([$exception->getMessage()], 400);
        }

    }

    /**
     * @Route("/{id}", name="order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return new JsonResponse(['id' => $order->getId(), 'user_id' => $order->getUser()->getId(), 'packs_id' => $order->getPacks()->getId(),
            'product_id' => $order->getProduct()->getId(), 'created_at' => $order->getCreatedAt(), 'updated_at' => $order->getUpdatedAt(), 'deleted_at' => $order->getDeletedAt()]);
    }

    /**
     * @Route("/edit/{id}", name="order_edit", methods={"GET","POST","PUT"})
     */
    public function edit(Request $request, Order $order): Response
    {
        try {
            $requestData = \json_decode($request->getContent(), true);


            $request->request->set('user_id', $requestData['user_id']);
            $request->request->set('packs_id', $requestData['packs_id']);
            $request->request->set('product_id', $requestData['product_id']);

            OrderType::setMethod('PUT');

            $form = $this->createForm(OrderType::class, new OrderInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var OrderInput $data */
                $data = $form->getData();

                $userRepository = $this->getDoctrine()->getRepository(Users::class);
                /** @var UserRepository $user */
                $user = $userRepository->find($requestData['user_id']);

                $packsRepository = $this->getDoctrine()->getRepository(Packs::class);
                /** @var PacksRepository $packs */
                $packs = $packsRepository->find($requestData['packs_id']);

                $productRepository = $this->getDoctrine()->getRepository(Product::class);
                /** @var ProductRepository $product */
                $product = $productRepository->find($requestData['product_id']);

                $order->setUser($user);
                $order->setProduct($product);
                $order->setPacks($packs);
                $order->setUpdatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($order);
                $entityManager->flush();

                return new JsonResponse(['id' => $order->getId(), 'user_id' => $order->getUser()->getId(), 'packs_id' => $order->getPacks()->getId(),
                    'product_id' => $order->getProduct()->getId(), 'created_at' => $order->getCreatedAt(), 'updated_at' => $order->getUpdatedAt(), 'deleted_at' => $order->getDeletedAt()]);

            }

        } catch (\Exception $exception) {
            return new JsonResponse([$exception->getMessage()], 400);
        }
    }

    /**
     * @Route("/delete/{id}", name="order_delete", methods={"POST","DELETE"})
     */
    public function delete(Order $order): JsonResponse
    {
        if (!$order->getId()) {
            return new JsonResponse([], 400);
        }

        $order->setStatus(false);
        $order->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse([], 204);
    }
}