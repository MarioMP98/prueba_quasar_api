<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;

class CategoryService
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {

        $this->repository = $repository;
    }

    public function list(): array
    {
        $arrayCollection = array();

        $categories = $this->repository->list();

        foreach($categories as $item) {
            $arrayCollection[] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'descripcion' => $item->getDescripcion(),
                'created_at' => $item->getCreatedAt(),
                'updated_at' => $item->getUpdatedAt(),
                'deleted_at' => $item->getDeletedAt()
            );
        }

        return $arrayCollection;

        
    }

    public function create($params): Category
    {

        return $this->repository->create($params);
    }

    public function update($id, $params): Category
    {

        return $this->repository->update($id, $params);
    }

    public function delete($id, $soft): void
    {

        $this->repository->delete($id, $soft);
    }
}
