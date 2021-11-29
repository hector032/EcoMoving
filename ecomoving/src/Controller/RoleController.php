<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Input\RoleInput;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/role")
 */
class RoleController extends AbstractController
{
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
     * @Route("/{id}/edit", name="role_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Role $role): Response
    {
        $data = json_decode($request->getContent(), true);

        $role->setName($data['name']);
        $role->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($role);
        $entityManager->flush();

        return new JsonResponse(['id' => $role->getId(), 'name' => $role->getName(), 'description' => $role->getDescription()]);
    }

    /**
     * @Route("/{id}", name="role_delete", methods={"POST"})
     */
    public function delete(Request $request, Role $role): Response
    {
        if ($this->isCsrfTokenValid('delete' . $role->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($role);
            $entityManager->flush();
        }

        return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
    }
}
