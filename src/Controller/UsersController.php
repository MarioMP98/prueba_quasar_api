<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends AbstractController
{
    public function test(): JsonResponse
    {

        return new JsonResponse("Hola, mundo");
    }
}
