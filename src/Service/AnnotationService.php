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

    public function list($onlyOld): array
    {

        $annotations = $this->repository->list($onlyOld);

        return $this->parseAnnotations($annotations);
    }

    public function create($params): Annotation
    {
        [$user, $categories] = $this->getUserAndCategories($params);

        return $this->repository->create($params, $user, $categories);
    }

    public function update($id, $params): Annotation
    {
        [$user, $categories] = $this->getUserAndCategories($params);

        return $this->repository->update($id, $params, $user, $categories);
    }

    public function delete($id, $soft): void
    {

        $this->repository->delete($id, $soft);
    }

    private function getUserAndCategories($params) {
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
