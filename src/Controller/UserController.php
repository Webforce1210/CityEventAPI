<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexUsers(): Response
    {
        return $this->json($this->serialize($this->userRepository->findAll()));
    }

    /**
     * @Route("/user-{id}", name="app_user_show", methods={"GET"})
     */
    public function showUser(int $id): Response{
        return $this->json(['user'=> $this->userRepository->find($id)->jsonSerialize(),]);
    }


    /**
     * @Route("/user/add", name="app_user_add",methods={"POST"})
     */
    public function addUser(Request $request): Response{
        try{
            $data = $request->request->all();
            $user = $this->hydrateUser(new User(), $data);
            $this->userRepository->add($user);

            return $this->json([
                'status' => 'success',
                'id' => $user->getId(),
                'data:'=>$data
            ]);
        } catch (\Exception $th) {
            return $this->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

/**
     * @Route("/user/{id}/update", name="app_user_update", methods={"POST"})
     */
    public function updateUser(int $id, Request $request): Response
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            return $this->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        try {
            $data = $request->request->all();
            $user = $this->hydrateUser($user, $data);
            $this->userRepository->add($user);

            return $this->json([
                'status' => 'success',
                'id' => $user->getId(),
            ]);
        } catch (\Exception $th) {
            return $this->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/user/{id}/delete", name="app_user_delete", methods={"POST"})
     */
    public function delete(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            return $this->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        } else {
            $this->userRepository->remove($user);
        }

        return $this->json([
            'status' => 'success',
        ]);
    }








    private function serialize(array $users): array
    {
        $data = [];
        foreach ($users as $user) {
            $data[] = $user->jsonSerialize();
        }

        return $data;
    }


    private function hydrateUser(User $user, array $data): User
    {
        $user
            ->setPseudo($data['pseudo'])
            ->setName($data['name'])
            ->setAvatar($data['avatar'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setStars($data['stars'])
            ->setCover($data['cover'])
            ->setRegion($data['region'])
            ->setHobbies($data['hobbies'])
        ;

        return $user;
    }









}
