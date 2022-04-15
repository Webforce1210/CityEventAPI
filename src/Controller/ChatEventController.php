<?php

namespace App\Controller;

use App\Entity\MessageActivite;
use App\Repository\EventRepository;
use App\Repository\MessageActiviteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatEventController extends AbstractController
{
    #[Route('/event/{id}/chat/add', name: 'app_chat_event', methods: ['POST'])]
    public function index(
        int $id,
        EventRepository $eventRepository,
        Request $request,
        MessageActiviteRepository $messageActiviteRepository
    ): Response {
        $user = $this->getUser();

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
                ], Response::HTTP_UNAUTHORIZED);
        }

        $event = $eventRepository->find($id);

        if (null === $event) {
            return $this->json([
                'status' => 'error',
                'message' => 'Event not found',
            ], 404);
        }

        try {
            $data = json_decode($request->getContent(), true);
            $message = (new MessageActivite())
                ->setDate(new DateTime())
                ->setMessage($data['message'])
                ->setUser($user)
                ->setEvent($event)
            ;
            $messageActiviteRepository->add($message);

            return $this->json([
                'message' => $message->getId(),
                'status' => 'success',
            ]);
        } catch (\Exception $th) {
            return $this->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
