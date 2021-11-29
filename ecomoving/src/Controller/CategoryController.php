<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Input\CategoryInput;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\FormValidationException;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/list", name="category_list", methods={"GET"})
     */
    public function list(CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $categoryRepository->findAll();

        $results = $paginator->paginate($categories, $request->get('page'), $request->get('limit'));
        $items= [];

        /** @var Category $category */
        foreach ($results->getItems() as $category) {
            $items[] = [
                'name' => $category->getName(),
                'description' => $category->getDescription(),
                'status' => $category->getStatus(),
            ];
        }

        $output =  [
             'items' => $items,
             'total' => $results->getTotalItemCount()
        ];
        
        return new JsonResponse($output);
    }

    /**
     * @Route("/create", name="category_create", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        try {

            $requestData = \json_decode($request->getContent(), true);

            $request->request->set('name', $requestData['name']);
            $request->request->set('description', $requestData['description']);
            $request->request->set('status', $requestData['status']);

            $form = $this->createForm(CategoryType::class, new CategoryInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var CategoryInput $data */
                $data = $form->getData();

                /** @var Category $category */
                $category = new Category();

                $category->setName($data->getName());
                $category->setDescription($data->getDescription());
                $category->setStatus($data->getStatus());
                $category->setCreatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($category);
                $entityManager->flush();

                return new JsonResponse(['sucess' => 'ok!']);

            } else {
                return new JsonResponse(['Error, valores no permitidos'], 400);
            }
        }catch (\Exception $exception){
            return new JsonResponse([$exception->getMessage()], 400);
        }

    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return new JsonResponse(['id' => $category->getId(), 'name' => $category->getName(), 'description' => $category->getDescription(),
            'status' => $category->getStatus(), 'created_at' => $category->getCreatedAt(), 'updated_at' => $category->getUpdatedAt(), 'deleted_at' => $category->getDeletedAt()]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        /*$form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }*/

        $data = json_decode($request->getContent(), true);

        $category->setName($data['name']);
        $category->setDescription($data['description']);
        $category->setStatus($data['status']);
        $category->setUpdatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return new JsonResponse(['id' => $category->getId(), 'name' => $category->getName(), 'description' => $category->getDescription(),
            'status' => $category->getStatus(), 'created_at' => $category->getCreatedAt(), 'updated_at' => $category->getUpdatedAt(), 'deleted_at' => $category->getDeletedAt()]);


    }

    /**
     * @Route("/{id}/delete", name="category_delete", methods={"POST"})
     */
    public function delete(Category $category): JsonResponse
    {
        if (!$category->getId()) {
            return new JsonResponse([], 400);
        }

        $category->setStatus(false);
        $category->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return new JsonResponse([],204);
    }
}
