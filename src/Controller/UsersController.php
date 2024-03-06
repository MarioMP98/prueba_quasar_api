<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends AbstractController
{
    protected $service;

    public function __construct(UserService $service)
    {

        $this->service = $service;
    }

    public function create(): JsonResponse
    {

        $response = $this->service->create();

        return new JsonResponse($response);
    }
}
