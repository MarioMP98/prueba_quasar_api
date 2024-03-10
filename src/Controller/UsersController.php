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
        try {

            $users = $this->service->list();

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al recuperar los usuarios");
        }

        return new JsonResponse($users);
    }


    public function create(Request $request): JsonResponse
    {
        try {

            $user = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al crear el usuario");
        }

        return new JsonResponse('Se ha creado un nuevo usuario con la id: ' . $user->getId());
    }


    public function update($id, Request $request): JsonResponse
    {
        try {

            $user = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al modificar el usuario");
        }

        if (!$user) {

            return new JsonResponse('No se ha encontrado el usuario a modificar');
        }

        return new JsonResponse('Se ha modificado el usuario con la id: ' . $user->getId());

    }


    public function delete($id, $soft): JsonResponse
    {
        try {

            $user = $this->service->delete($id, $soft);

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al eliminar el usuario");
        }

        if (!$user) {

            return new JsonResponse('No se ha encontrado el usuario a eliminar');
        }

        return new JsonResponse('Se ha eliminado correctamente el usuario');
    }
}
