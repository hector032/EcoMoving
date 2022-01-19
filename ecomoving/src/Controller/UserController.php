<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;

use App\Form\UserType;
use App\Input\UserInput;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/user")
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
        $items = [];

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
     * @Route("/create", name="user_create", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        try {

            $requestData = \json_decode($request->getContent(), true);

            $request->request->set('firstName', $requestData['firstName']);
            $request->request->set('lastName', $requestData['lastName']);
            $request->request->set('address', $requestData['address']);
            $request->request->set('country', $requestData['country']);
            $request->request->set('city', $requestData['city']);
            $request->request->set('zip_code', $requestData['zip_code']);
            $request->request->set('phone', $requestData['phone']);
            $request->request->set('status', $requestData['status']);
            $request->request->set('role_id', $requestData['role_id']);

            $form = $this->createForm(UserType::class, new UserInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                /** @var UserInput $data */
                $data = $form->getData();

                /** @var User $user */
                $user = new User();

                $roleRepository = $this->getDoctrine()->getRepository(Role ::class);
                /** @var RoleRepository $role */
                $role = $roleRepository->find($data->getRoleId());

                $user->setFirstName($data->getFirstName());
                $user->setLastName($data->getLastName());
                $user->setAddress($data->getAddress());
                $user->setCountry($data->getCountry());
                $user->setCity($data->getCity());
                $user->setZipCode($data->getZipCode());
                $user->setPhone($data->getPhone());
                $user->setStatus($data->getStatus());
                $user->setRole($role);
                $user->setCreatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return new JsonResponse(['sucess' => 'ok!']);

            } else {
                dd($form->getErrors());
                return new JsonResponse(['Error, valores no permitidos y/o request no completos'], 400);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([$exception->getMessage()], 400);
        }

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
        try{
            $requestData = \json_decode($request->getContent(),true);

            $request->request->set('firstName', $requestData['firstName']);
            $request->request->set('lastName', $requestData['lastName']);
            $request->request->set('address', $requestData['address']);
            $request->request->set('country', $requestData['country']);
            $request->request->set('city', $requestData['city']);
            $request->request->set('zip_code', $requestData['zip_code']);
            $request->request->set('phone', $requestData['phone']);
            $request->request->set('status', $requestData['status']);
            $request->request->set('role_id', $requestData['role_id']);

            $form= $this->createForm(UserType::class,new UserInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                /** @var UserInput $data */
                $data = $form->getData();

                $roleRepository = $this->getDoctrine()->getRepository(Role::class);
                /** @var Role $role */
                $role=$roleRepository->find($data->getRoleId());

                $user->setFirstName($data->getFirstName());
                $user->setLastName($data->getLastName());
                $user->setAddress($data->getAddress());
                $user->setCountry($data->getCountry());
                $user->setAddress($data->getAddress());
                $user->setCity($data->getCity());
                $user->setZipCode($data->getZipCode());
                $user->setPhone($data->getPhone());
                $user->setStatus($data->getStatus());
                $user->setRole($role);
                $user->setUpdatedAt( new \DateTime());

                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                //dd($user);
                return new JsonResponse(['id' => $user->getId(), 'firstName' => $user->getFirstName(), 'lastName' => $user->getLastName(),
                    'address' => $user->getAddress(),'country' => $user->getCountry(),'city' => $user->getCity(),'zip_code' => $user->getZipCode(), 'phone' => $user->getPhone(),
                    'status' => $user->getStatus(),
                    'role_id' => $user->getRole()->getId(), 'created_at' => $user->getCreatedAt(), 'updated_at' => $user->getUpdatedAt(), 'deleted_at' => $user->getDeletedAt()]);

            }
        }
        catch (\Exception $exception){
            return new JsonResponse([$exception->getMessage()],400);
        }


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
