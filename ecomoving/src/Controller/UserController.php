<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\FormValidationException;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/list", name="user_list", methods={"GET"})
     */
    public function list(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $userRepository->findAll();

        $results = $paginator->paginate($users, $request->get('page'), $request->get('limit'));
        $items= [];

        /** @var User $user */
        foreach ($results->getItems() as $user) {
            $items[] = [
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'address' => $user->getAddress(),
                'country' => $user->getCountry(),
                'city' => $user->getCity(),
                'zipCode' => $user->getZipCode(),
                'phone' => $user->getPhone(),
                'roleId' => $user->getRole()->getId(),
                'status' => $user->getStatus(),
            ];
        }

        $output = [
            'items' => $items,
            'total' => $results->getTotalItemCount()
        ];
        return new JsonResponse($output);
    }

    /**
     * @Route("/create", name="user_create", methods={"POST"})
     * @throws FormValidationException
     */
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = new User();
        $requestData = \json_decode($request->getContent(), true);


        $roleRepository = $this->getDoctrine()->getRepository(Role::class);
        /** @var Role $role */
        $role = $roleRepository->find($requestData['role_id']);

        $user->setFirstName($requestData['first_name']);
        $user->setLastName($requestData['last_name']);
        $user->setAddress($requestData['address']);
        $user->setCountry($requestData['country']);
        $user->setCity($requestData['city']);
        $user->setZipCode($requestData['zip_code']);
        $user->setPhone($requestData['phone']);
        $user->setRole($role);
        $user->setStatus($requestData['status']);
        $user->setCreatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['sucess' => 'ok!']);


    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): JsonResponse
    {
        return new JsonResponse(['id' => $user->getId(), 'first_name' => $user->getFirstName(), 'last_name' => $user->getLastName(),
            'address' => $user->getAddress(), 'country' => $user->getCountry(), 'city' => $user->getCity(), 'zip_code' => $user->getZipCode()
            , 'phone' => $user->getPhone(), 'role_id' => $user->getRole()->getId(), 'created_at' => $user->getCreatedAt(), 'updated_at' => $user->getUpdatedAt(), 'deleted_at' => $user->getDeletedAt()]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();

        $roleRepository = $this->getDoctrine()->getRepository(Role::class);
        /** @var Role $role */
        $role = $roleRepository->find($data['role_id']);

        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setAddress($data['address']);
        $user->setCountry($data['country']);
        $user->setCity($data['city']);
        $user->setZipCode($data['zip_code']);
        $user->setPhone($data['phone']);
        $user->setRole($role);
        $user->setUpdatedAt(new \DateTime());

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['id' => $user->getId(), 'first_name' => $user->getFirstName(), 'last_name' => $user->getLastName(),
            'address' => $user->getAddress(), 'country' => $user->getCountry(), 'city' => $user->getCity(), 'zip_code' => $user->getZipCode()]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete", methods={"POST"})
     */
    public function delete(User $user): JsonResponse
    {
        if (!$user->getId()) {
            return new JsonResponse([], 400);
        }

        $user->setStatus(false);
        $user->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse([], 204);
    }
}
