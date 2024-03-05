<?php

namespace App\Service;

use App\Repository\UsersRepository;

class UsersService
{
    protected $repository;

    public function __construct(UsersRepository $repository)
    {

        $this->repository = $repository;
    }

    public function create(): string
    {

        return $this->repository->create();
    }
}
