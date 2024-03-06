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

    public function create(): null|User
    {

        return $this->repository->create(1);
    }
}
