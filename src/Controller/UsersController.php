<?php

namespace App\Controller;

use App\Service\UsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends AbstractController
{
    protected $service;

    public function __construct(UsersService $service)
    {

        $this->service = $service;
    }

    public function create(): JsonResponse
    {

        $response = $this->service->create();

        return new JsonResponse($response);
    }
}
