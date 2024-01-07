<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="login", methods={"POST"})
     */
    public function login(Request $request): JsonResponse
    {
        $userData = json_decode($request->getContent(), true);

        $username = 'usuarioAutorizado'; 
        $password = 'password123';

        if ($userData['username'] === $username && $userData['password'] === $password) {
            $token = base64_encode(random_bytes(32)).$username; 
            return $this->json([
                'message' => 'Login successful!',
                'token' => $token,
            ]);

        } else {
            return $this->json([
                'message' => 'Authentication failed. Invalid username or password.',
            ], 401);
        }
    }
}
