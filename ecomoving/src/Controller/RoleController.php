<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Input\RoleInput;
use App\Repository\RoleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/api/role")
 */
class RoleController extends AbstractController
{
    /**
     * @Route("/list", name="order_list", methods={"GET"})
     */
    public function list(RoleRepository $roleRepository, PaginatorInterface $paginator, Request $request): Response
    {

        //TODO: its need apply limti in this query
        $roles = $roleRepository->findAll();

        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 500;

        $results = $paginator->paginate($roles, $page, $limit);

        $items = [];

        /** @var Role $role */
        foreach ($results->getItems() as $role) {
            $items[] = [
                'id' => $role->getId(),
                'name' => $role->getName(),
                'description' => $role->getDescription()
            ];
        }

        $output = [
            'items' => $items,
            'total' => $results->getTotalItemCount()
        ];

        return new JsonResponse($output);
    }

    /**
     * @Route("/", name="role_index", methods={"GET"})
     */
    public function index(RoleRepository $roleRepository): Response
    {
        return $this->render('role/index.html.twig', [
            'roles' => $roleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="role_create", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        try {

            $requestData = \json_decode($request->getContent(), true);

            $request->request->set('name', $requestData['name']);
            $request->request->set('description', $requestData['description']);

            RoleType::setMethod('POST');

            $form = $this->createForm(RoleType::class, new RoleInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var RoleInput $data */
                $data = $form->getData();

                /** @var Role $role */
                $role = new Role();

                $role->setName($data->getName());
                $role->setDescription($data->getDescription());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($role);
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
     * @Route("/{id}", name="role_show", methods={"GET"})
     */
    public function show(Role $role): Response
    {
        return new JsonResponse(['id' => $role->getId(), 'name' => $role->getName(), 'description' => $role->getDescription()]);
    }

    /**
     * @Route("/edit/{id}", name="role_edit", methods={"GET","POST","PUT"})
     */
    public function edit(Request $request, Role $role): Response
    {
        try {

            $requestData = \json_decode($request->getContent(), true);

            $request->request->set('name', $requestData['name']);
            $request->request->set('description', $requestData['description']);


            RoleType::setMethod('PUT');

            $form = $this->createForm(RoleType::class, new RoleInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var RoleInput $data */
                $data = $form->getData();

                $role->setName($data->getName());
                $role->setDescription($data->getDescription());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($role);
                $entityManager->flush();

                return new JsonResponse(['id' => $role->getId(), 'name' => $role->getName(), 'description' => $role->getDescription()]);

            } else {
                return new JsonResponse(['Error, valores no permitidos'], 400);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([$exception->getMessage()], 400);
        }
    }

    /**
     * @Route("/{id}", name="role_delete", methods={"POST"})
     */
    public function delete(Request $request, Role $role): Response
    {
        if (!$role->getId()) {
            return new JsonResponse([], 400);
        }

        $role->setStatus(false);
        $role->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($role);
        $entityManager->flush();

        return new JsonResponse([], 204);
    }
}
