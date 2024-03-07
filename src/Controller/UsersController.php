<?php

namespace App\Controller;

use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController
{
    protected $service;

    public function __construct(UserService $service)
    {

        $this->service = $service;
    }

    public function findAll(): JsonResponse
    {

        $users = $this->service->findAll();

        return new JsonResponse($users);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {

        $user = $this->service->create($request->request->all(), $entityManager);

        return new JsonResponse('Se ha creado un nuevo usuario con la id: ' . $user->getId());
    }
}
