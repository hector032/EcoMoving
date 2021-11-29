<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\FormValidationException;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/list", name="product_list", methods={"GET"})
     */
    public function list(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        //TODO: its need apply limti in this query
        $products = $productRepository->findAll();

        $results = $paginator->paginate($products, $request->get('page'), $request->get('limit'));
        $items= [];

        /** @var Product $product */
        foreach ($results->getItems() as $product) {
            $items[] = [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'status' => $product->getStatus()
            ];
        }

        $output = [
            'items' => $items,
            'total' => $results->getTotalItemCount()
        ];

        return new JsonResponse($output);
    }

    /**
     * @Route("/create", name="product_create", methods={"POST"})
     * @throws FormValidationException
     */
    public function create(Request $request): Response
    {
        /** @var Product $product */
        $product = new Product();
        $requestData = \json_decode($request->getContent(), true);

        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        /** @var Category $category */
        $category=$categoryRepository->find($requestData['category_id']);

        $product->setName($requestData['name']);
        $product->setDescription($requestData['description']);
        $product->setStatus($requestData['status']);
        $product->setCategory($category);
        $product->setCreatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse(['sucess' => 'ok!']);

    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return new JsonResponse(['id' => $product->getId(), 'name' => $product->getName(), 'description' => $product->getDescription(),
            'status' => $product->getStatus(), 'created_at' => $product->getCreatedAt(), 'updated_at' => $product->getUpdatedAt(), 'deleted_at' => $product->getDeletedAt()]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $data = json_decode($request->getContent(), true);

        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setStatus($data['status']);
        $product->setUpdatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse(['id' => $product->getId(), 'name' => $product->getName(), 'description' => $product->getDescription(),
            'status' => $product->getStatus(), 'created_at' => $product->getCreatedAt(), 'updated_at' => $product->getUpdatedAt(), 'deleted_at' => $product->getDeletedAt()]);
    }

    /**
     * @Route("/{id}/delete", name="product_delete", methods={"POST"})
     */
    public function delete(Product $product): JsonResponse
    {
        if (!$product->getId()) {
            return new JsonResponse([], 400);
        }

        $product->setStatus(false);
        $product->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse([],204);
    }
}
