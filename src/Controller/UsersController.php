<?php

namespace App\Controller;

use App\Service\UserService;
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

    public function list(): JsonResponse
    {

        $users = $this->service->list();

        return new JsonResponse($users);
    }

    public function create(Request $request): JsonResponse
    {

        $user = $this->service->create($request->request->all());

        return new JsonResponse('Se ha creado un nuevo usuario con la id: ' . $user->getId());
    }

    public function update($id, Request $request): JsonResponse
    {

        $user = $this->service->update($id, $request->request->all());

        return new JsonResponse('Se ha modificado el usuario con la id: ' . $user->getId());

    }

    public function delete($id, $soft): JsonResponse
    {
        $this->service->delete($id, $soft);

        return new JsonResponse('Se ha eliminado correctamente el usuario');
    }
}
