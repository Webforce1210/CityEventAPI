<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    public function __construct(
        private UserRepository $userRepository
    )
    {

    }


    /**
     * @Route("/users", name="app_users", methods={"GET"})
     */ 
    public function userindex(): Response
    {
        // return $this->json([
        //     'users' => $this->userRepository->findAll(),
        // ]);
        return $this->json($this->serialize($this->userRepository->findAll()));
    }

    /**
     * @Route("/user/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(int $id): Response{
        return $this->json(['user'=> $this->userRepository->find($id)->jsonSerialize(),]);
    }



    private function serialize(array $users): array
    {
        $data = [];
        foreach ($users as $user) {
            $data[] = $user->jsonSerialize();
        }

        return $data;
    }












}
