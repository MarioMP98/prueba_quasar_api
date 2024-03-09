<?php

namespace App\Service;

use App\Entity\Annotation;
use App\Repository\AnnotationRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;

class AnnotationService
{
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

    public function list(): array
    {
        $arrayCollection = array();

        $annotations = $this->repository->list();

        foreach($annotations as $item) {
            $user = $item->getUsuario();

            $arrayCollection[] = array(
                'id' => $item->getId(),
                'usuario' => $user->getNombre() ?? '',
                'nota' => $item->getNota(),
                'created_at' => $item->getCreatedAt(),
                'updated_at' => $item->getUpdatedAt(),
                'deleted_at' => $item->getDeletedAt()
            );
        }

        return $arrayCollection;

        
    }

    public function create($params): Annotation
    {
        $user = $this->userRepository->find($params['usuario']);

        return $this->repository->create($params, $user);
    }

    public function update($id, $params): Annotation
    {
        $user = $this->userRepository->find($params['usuario']);

        return $this->repository->update($id, $params, $user);
    }

    public function delete($id, $soft): void
    {

        $this->repository->delete($id, $soft);
    }
}
