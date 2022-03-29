<?php

namespace App\Controller;
use App\Entity\Packs;
use App\Form\PacksType;
use App\Input\PacksInput;
use App\Repository\PacksRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/packs")
 */

class PacksController extends AbstractController
{

    /**
     * @Route("/list", name="packs_list", methods={"GET"})
     */
    public function list(PacksRepository $packsRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $packs = $packsRepository->findAll();

        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') :500;

        $results = $paginator->paginate($packs, $page, $limit);
        $items = [];

        /** @var Packs $pack */
        foreach ($results->getItems() as $pack) {
            $items[] = [
                'id' => $pack->getId(),
                'name' => $pack->getName(),
                'description' => $pack->getDescription(),
                'status' => $pack->getStatus(),
                'duration' => $pack->getDuration(),
                'price' =>$pack->getPrice()

            ];
        }

        $output = [
            'items' => $items,
            'total' => $results->getTotalItemCount()
        ];

        return new JsonResponse($output);
    }

    /**
     * @Route("/create", name="packs_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $requestData = \json_decode($request->getContent(), true);

            $request->request->set('name', $requestData['name']);
            $request->request->set('description', $requestData['description']);
            $request->request->set('duration', $requestData['duration']);
            $request->request->set('price', $requestData['price']);
            $request->request->set('status', $requestData['status']);

            PacksType::setMethod('POST');

            $form = $this->createForm(PacksType::class, new PacksInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var PacksInput $data */
                $data = $form->getData();

                /** @var Packs $packs */
                $packs = new Packs();

                $packs->setName($data->getName());
                $packs->setDescription($data->getDescription());
                $packs->setDuration($data->getDuration());
                $packs->setPrice($data->getPrice());
                $packs->setStatus($data->getStatus());

                $packs->setCreatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($packs);
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
     * @Route("/{id}", name="packs_show", methods={"GET"})
     */
    public function show(Packs $packs): Response
    {
        return new JsonResponse(['id' => $packs->getId(), 'name' => $packs->getName(), 'description' => $packs->getDescription(),
            'duration' => $packs->getDuration(), 'price' => $packs->getPrice(),'status' =>$packs->getStatus(), 'created_at' => $packs->getCreatedAt(), 'updated_at' => $packs->getUpdatedAt(), 'deleted_at' => $packs->getDeletedAt()]);
    }

    /**
     * @Route("/edit/{id}", name="packs_edit", methods={"PUT"})
     */
    public function edit(Request $request, Packs $packs): Response
    {

        try {

            $requestData = \json_decode($request->getContent(), true);

            $request->request->set('name', $requestData['name']);
            $request->request->set('description', $requestData['description']);
            $request->request->set('duration', $requestData['duration']);
            $request->request->set('price', $requestData['price']);
            $request->request->set('status', $requestData['status']);

            PacksType::setMethod('PUT');

            $form = $this->createForm(PacksType::class, new PacksInput());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var PacksInput $data */
                $data = $form->getData();

                $packs->setName($data->getName());
                $packs->setDescription($data->getDescription());
                $packs->setDuration($data->getDuration());
                $packs->setPrice($data->getPrice());
                $packs->setStatus($data->getStatus());
                $packs->setUpdatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($packs);
                $entityManager->flush();

                return new JsonResponse(['id' => $packs->getId(), 'name' => $packs->getName(), 'description' => $packs->getDescription(),
                    'duration' => $packs->getDuration(), 'price' => $packs->getPrice(),'status' =>$packs->getStatus(), 'created_at' => $packs->getCreatedAt(), 'updated_at' => $packs->getUpdatedAt(), 'deleted_at' => $packs->getDeletedAt()]);

            } else {
                return new JsonResponse(['Error, valores no permitidos'], 400);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([$exception->getMessage()], 400);
        }
    }
    /**
     * @Route("/delete/{id}", name="packs_delete", methods={"POST", "DELETE"})
     */
    public function delete(Packs $packs): JsonResponse
    {
        if (!$packs->getId()) {
            return new JsonResponse([], 400);
        }

        $packs->setStatus(false);
        $packs->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($packs);
        $entityManager->flush();

        return new JsonResponse(['sucess' => 'ok!']);
    }

}