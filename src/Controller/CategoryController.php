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


    /**
     * Recupera todas las categorías
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {

            $categories = $this->service->list();

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al recuperar las categorías");
        }
        
        return new JsonResponse($categories);
    }


    /**
     * Crea una categoría nueva
     *
     * @param Request $request Contiene los parametros a guardar
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {

            $category = $this->service->create($request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al crear la categoría");
        }

        return new JsonResponse('Se ha creado una nueva categoría con la id: ' . $category->getId());
    }


    /**
     * Actualiza una categoría existente
     *
     * @param int $id La id de la categoría a modificar
     * @param Request $request Contiene los parametros a guardar
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        try {

            $category = $this->service->update($id, $request->request->all());

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al modificar la categoría");
        }

        if (!$category) {

            return new JsonResponse('No se ha encontrado la categoría a modificar');
        }

        return new JsonResponse('Se ha modificado la categoría con la id: ' . $category->getId());

    }


    /**
     * Elimina una categoría existente
     *
     * @param int $id La id de la categoría a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return JsonResponse
     */
    public function delete($id, $soft): JsonResponse
    {
        try {

            $category = $this->service->delete($id, $soft);

        } catch (\Exception) {

            return new JsonResponse("Se ha producido un error al eliminar la categoría");
        }

        if (!$category) {

            return new JsonResponse('No se ha encontrado la categoría a eliminar');
        }
        

        return new JsonResponse('Se ha eliminado correctamente la categoría');
    }
}
