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

    public function list($onlyOld): JsonResponse
    {
        try {

            $annotations = $this->service->list($onlyOld);

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al recuperar las notas");
        }

        return new JsonResponse($annotations);
    }

    public function create(Request $request): JsonResponse
    {
        try {

            $annotation = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al crear la nota");
        }

        return new JsonResponse('Se ha creado una nueva nota con la id: ' . $annotation->getId());
    }

    public function update($id, Request $request): JsonResponse
    {
        try {

            $annotation = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al modificar la nota");
        }

        return new JsonResponse('Se ha modificado la nota con la id: ' . $annotation->getId());

    }

    public function delete($id, $soft): JsonResponse
    {
        try {

            $this->service->delete($id, $soft);

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al eliminar la nota");
        }

        return new JsonResponse('Se ha eliminado correctamente la nota');
    }
}
