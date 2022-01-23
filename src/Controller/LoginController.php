<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["POST"])]
    public function index(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $payload = json_decode($request->getContent(), true);

        $email = $payload['email'];
        $plainPassword = $payload['password'];

        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return $this->json(['error' => 'Incorrect Credentials']);
        }

        if ($passwordHasher->isPasswordValid($user, $plainPassword)) {
            return $this->json(['user' => [
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "firstName" => $user->getFirstName(),
                "lastName" => $user->getLastName(),
                "userRoles" => $user->getRoles()
            ]]);
        }

        return $this->json(['error' => 'Incorrect Credentials']);
    }
}
