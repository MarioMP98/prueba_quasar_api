<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Traits\Parser;

class CategoryService
{
    use Parser;

    protected $repository;


    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }


    public function list(): array
    {
        $categories = $this->repository->list();

        return $this->parseCategories($categories);
    }


    public function create($params): Category
    {

        return $this->repository->create($params);
    }


    public function update($id, $params): Category|null
    {

        return $this->repository->update($id, $params);
    }


    public function delete($id, $soft): Category|null
    {

        return $this->repository->delete($id, $soft);
    }
}
