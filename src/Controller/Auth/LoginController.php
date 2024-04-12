<?php

namespace App\Controller\Auth;

use App\Entity\Partner;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


class LoginController extends AbstractController
{

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function index(#[CurrentUser] ?Partner $partner, JWTTokenManagerInterface $JWTManager): Response
    {
        if (null === $partner) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $JWTManager->create($partner);

        return $this->json([

            'user'  => $partner,
            'token' => $token,
        ]);
    }
}
