<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Hydrator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register", methods={"POST"})
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {
        if (null !== $this->getUser()) {
            return $this->json([
                'message' => 'User already authentificated',
                'status' => 'error',
            ]);
        }

        try {
            $user = $this->createUser(json_decode($request->getContent(), true));
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $session->set('_security_main', serialize($user));

            return $this->json([
                'userId' => $user->getId(),
                'status' => 'success',
            ]);
        } catch (\Exception $th) {
            return $this->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function createUser(array $data): User
    {
        /** @var User */
        $user = Hydrator::hydrate($data, new User());

        $user
            ->setStars(0)
            ->setName($user->getPseudo() ?? '')
            ->setRoles(['ROLE_USER'])
            ->setCover('')
        ;

        return $user;
    }
}
