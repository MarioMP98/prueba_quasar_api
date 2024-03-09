<?php

namespace App\Controller;

use App\Service\AnnotationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AnnotationController extends AbstractController
{
    protected $service;

    public function __construct(AnnotationService $service)
    {

        $this->service = $service;
    }

    public function list(): JsonResponse
    {

        $annotations = $this->service->list();

        return new JsonResponse($annotations);
    }

    public function create(Request $request): JsonResponse
    {

        $annotation = $this->service->create($request->request->all());

        return new JsonResponse('Se ha creado una nueva nota con la id: ' . $annotation->getId());
    }

    public function update($id, Request $request): JsonResponse
    {

        $annotation = $this->service->update($id, $request->request->all());

        return new JsonResponse('Se ha modificado la nota con la id: ' . $annotation->getId());

    }

    public function delete($id, $soft): JsonResponse
    {
        $this->service->delete($id, $soft);

        return new JsonResponse('Se ha eliminado correctamente la nota');
    }
}
