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

    public function findAll(): array
    {
        $arrayCollection = array();

        $users = $this->repository->findAll();

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

    public function create($params, $em): User
    {

        return $this->repository->create($params, $em);
    }
}
