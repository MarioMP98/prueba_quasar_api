<?php

namespace App\Controller;

use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    protected $service;

    public function __construct(CategoryService $service)
    {

        $this->service = $service;
    }

    public function list(): JsonResponse
    {

        $categories = $this->service->list();

        return new JsonResponse($categories);
    }

    public function create(Request $request): JsonResponse
    {

        $category = $this->service->create($request->request->all());

        return new JsonResponse('Se ha creado una nueva categoría con la id: ' . $category->getId());
    }

    public function update($id, Request $request): JsonResponse
    {

        $user = $this->service->update($id, $request->request->all());

        return new JsonResponse('Se ha modificado la categoría con la id: ' . $user->getId());

    }

    public function delete($id, $soft): JsonResponse
    {
        $this->service->delete($id, $soft);

        return new JsonResponse('Se ha eliminado correctamente la categoría');
    }
}
