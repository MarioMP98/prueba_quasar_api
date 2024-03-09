<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {

        $this->repository = $repository;
    }

    public function list(): array
    {
        $arrayCollection = array();

        $users = $this->repository->list();

        foreach($users as $item) {
            $arrayCollection[] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'email' => $item->getEmail(),
                'password' => $item->getPassword(),
                'created_at' => $item->getCreatedAt(),
                'updated_at' => $item->getUpdatedAt(),
                'deleted_at' => $item->getDeletedAt()
            );
        }

        return $arrayCollection;

        
    }

    public function create($params): User
    {

        return $this->repository->create($params);
    }

    public function update($id, $params): User
    {

        return $this->repository->update($id, $params);
    }

    public function delete($id, $soft): void
    {

        $this->repository->delete($id, $soft);
    }
}
