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


    /**
     * Recupera todas las notas
     *
     * @param boolean $onlyOld Sirve para que solo traiga las notas creadas hace más de 7 días
     * @return JsonResponse
     */
    public function list($onlyOld): JsonResponse
    {
        try {

            $annotations = $this->service->list($onlyOld);

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al recuperar las notas");
        }

        return new JsonResponse($annotations);
    }


    /**
     * Crea una nota nueva
     *
     * @param Request $request Contiene los parametros a guardar
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {

            $annotation = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al crear la nota");
        }

        return new JsonResponse('Se ha creado una nueva nota con la id: ' . $annotation->getId());
    }


    /**
     * Actualiza una nota existente
     *
     * @param int $id La id de la nota a modificar
     * @param Request $request Contiene los parametros a guardar
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        try {

            $annotation = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al modificar la nota");
        }

        if (!$annotation) {

            return new JsonResponse('No se ha encontrado la nota a modificar');
        }

        return new JsonResponse('Se ha modificado la nota con la id: ' . $annotation->getId());

    }


    /**
     * Elimina una nota existente
     *
     * @param int $id La id de la nota a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return JsonResponse
     */
    public function delete($id, $soft): JsonResponse
    {
        try {

            $annotation = $this->service->delete($id, $soft);

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al eliminar la nota");
        }

        if (!$annotation) {

            return new JsonResponse('No se ha encontrado la nota a eliminar');
        }

        return new JsonResponse('Se ha eliminado correctamente la nota');
    }
}
