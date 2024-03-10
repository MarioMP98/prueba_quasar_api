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

    public function list(): array
    {

        $users = $this->repository->list();

        return $this->parseUsers($users);

        
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
