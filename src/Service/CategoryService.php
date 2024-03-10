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


    /**
     * Recupera todas las categorías
     *
     * @return array
     */
    public function list(): array
    {
        $categories = $this->repository->list();

        return $this->parseCategories($categories);
    }


    /**
     * Crea una categoría nueva
     *
     * @param array $params Contiene los parametros a guardar
     * @return Category
     */
    public function create($params): Category
    {

        return $this->repository->create($params);
    }


    /**
     * Actualiza una categoría existente
     *
     * @param int $id La id de la categoría a modificar
     * @param array $params Contiene los parametros a guardar
     * @return Category|null
     */
    public function update($id, $params): Category|null
    {

        return $this->repository->update($id, $params);
    }


    /**
     * Elimina una categoría existente
     *
     * @param int $id La id de la categoría a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return Category|null
     */
    public function delete($id, $soft): Category|null
    {

        return $this->repository->delete($id, $soft);
    }
}
