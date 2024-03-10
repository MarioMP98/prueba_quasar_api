<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Traits\Parser;

class UserService
{
    use Parser;

    protected $repository;


    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Recupera todos los usuarios
     *
     * @return array
     */
    public function list(): array
    {
        $users = $this->repository->list();

        return $this->parseUsers($users);
    }


    /**
     * Crea un usuario nuevo
     *
     * @param array $params Contiene los parametros a guardar
     * @return User
     */
    public function create($params): User
    {

        return $this->repository->create($params);
    }


    /**
     * Actualiza un usuario existente
     *
     * @param int $id La id del usuario a modificar
     * @param array $params Contiene los parametros a guardar
     * @return User|null
     */
    public function update($id, $params): User|null
    {

        return $this->repository->update($id, $params);
    }


    /**
     * Elimina un usuario existente
     *
     * @param int $id La id del usuario a eliminar
     * @param boolean $soft Determina si se realiza o no un SoftDelete
     * @return User|null
     */
    public function delete($id, $soft): User|null
    {

        return $this->repository->delete($id, $soft);
    }
}
