<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        SessionInterface $session
    ): Response {
        $user = $this->getUser();

        if ($user instanceof User) {
            return $this->json([
                'userId' => $user->getId(),
                'status' => 'success',
            ]);
        }

        $data = json_decode($request->getContent());
        $user = $userRepository->findOneBy(['email' => $data->email]);

        if (null !== $user && $passwordHasher->isPasswordValid($user, $data->password)) {
            $session->set('_security_main', serialize($user));

            return $this->json([
                'userId' => $user->getId(),
                'status' => 'success',
            ]);
        }

        return $this->json([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
