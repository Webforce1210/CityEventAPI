<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\JsonHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $users = JsonHelper::serialize($this->userRepository->findAll());

        return $this->json([
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show')]
    public function show(int $id): Response
    {
        $user = $this->userRepository->findUser($id);

        if (null === $user) {
            return $this->json(
                ['status' => 'error', 'message' => 'User not found'],
                404
            );
        }

        $data = $user->jsonSerialize();
        $data->userEvents = $data->userEvents->toArray();
        foreach ($data->userEvents as &$userEvent) {
            $userEvent = $userEvent->jsonSerialize();
            $userEvent->event = $userEvent->event->jsonSerialize();
        }

        return $this->json($data);
    }
}
