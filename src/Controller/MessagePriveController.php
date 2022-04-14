<?php

namespace App\Controller;

use App\Repository\MessagePriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagePriveController extends AbstractController
{

    public function __construct(
        private MessagePriveRepository $messagePriveRepository
    ){
    } 
    /**
     * @Route("/messagepv", name="app_messageprive", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json($this->serialize($this->messagePriveRepository->findAll()));
    }


    

    private function serialize(array $messageprives): array
    {
        $data = [];
        foreach ($messageprives as $messagepv) {
            $data[] = $messagepv->jsonSerialize();
        }

        return $data;
    }
}
