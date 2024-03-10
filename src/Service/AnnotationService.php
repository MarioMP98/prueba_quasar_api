<?php

namespace App\Service;

use App\Entity\Annotation;
use App\Repository\AnnotationRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Traits\Parser;

class AnnotationService
{
    use Parser;

    protected $repository;
    protected $userRepository;
    protected $categoryRepository;


    public function __construct(
        AnnotationRepository $repository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Recupera todas las notas
     *
     * @param boolean $onlyOld Sirve para que solo traiga las notas creadas hace más de 7 días
     * @return array
     */
    public function list($onlyOld): array
    {
        $annotations = $this->repository->list($onlyOld);

        return $this->parseAnnotations($annotations);
    }


    /**
     * Crea una nota nueva
     *
     * @param array $params Contiene los parametros a guardar
     * @return Annotation
     */
    public function create($params): Annotation
    {
        [$user, $categories] = $this->getUserAndCategories($params);

        return $this->repository->create($params, $user, $categories);
    }


    /**
     * Actualiza una nota existente
     *
     * @param int $id La id de la nota a modificar
     * @param array $params Contiene los parametros a guardar
     * @return Annotation|null
     */
    public function update($id, $params): Annotation|null
    {
        [$user, $categories] = $this->getUserAndCategories($params);

        return $this->repository->update($id, $params, $user, $categories);
    }


    /**
     * Elimina una nota existente
     *
     * @param int $id La id de la nota a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return Annotation|null
     */
    public function delete($id, $soft): Annotation|null
    {

        return $this->repository->delete($id, $soft);
    }


    /**
     * Recupera los usuarios y las categorías correspondientes a los ids recibidos
     *
     * @param array $params Contiene los parametros a guardar
     * @return array
     */
    private function getUserAndCategories($params): array
    {
        $user = null;
        $categories = array();

        if (isset($params['categorias'])) {
            $categories = $this->categoryRepository->findIn($params['categorias']);
        }

        if (isset($params['usuario'])) {
            $user = $this->userRepository->find($params['usuario']);
        }

        return [$user, $categories];
    }
}
