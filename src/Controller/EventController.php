<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    public function __construct(
        private EventRepository $eventRepository
    ) {
    }

    /**
     * @Route("/", name="app_event", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json($this->serialize($this->eventRepository->findAll()));
    }

    /**
     * @Route("/event/last", name="app_event_last", methods={"GET"})
     */
    public function lastEvents(): Response
    {
        return $this->json($this->serialize($this->eventRepository->findLastEvents()));
    }

    /**
     * @Route("/event/{id}", name="app_event_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        return $this->json([
            'event' => $this->eventRepository->find($id)->jsonSerialize()
        ]);
    }

    /**
     * @Route("/event/add", name="app_event_add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        try {
            $data = $request->request->all();
            $event = $this->hydrate(new Event(), $data);
            $this->eventRepository->add($event);

            return $this->json([
                'status' => 'success',
                'id' => $event->getId(),
            ]);
        } catch (\Exception $th) {
            return $this->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/event/{id}/update", name="app_event_update", methods={"POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $event = $this->eventRepository->find($id);

        if (null === $event) {
            return $this->json([
                'status' => 'error',
                'message' => 'Event not found',
            ], 404);
        }

        try {
            $data = $request->request->all();
            $event = $this->hydrate($event, $data);
            $this->eventRepository->add($event);

            return $this->json([
                'status' => 'success',
                'id' => $event->getId(),
            ]);
        } catch (\Exception $th) {
            return $this->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/event/{id}/delete", name="app_event_delete", methods={"POST"})
     */
    public function delete(int $id): Response
    {
        $event = $this->eventRepository->find($id);

        if (null === $event) {
            return $this->json([
                'status' => 'error',
                'message' => 'Event not found',
            ], 404);
        } else {
            $this->eventRepository->remove($event);
        }

        return $this->json([
            'status' => 'success',
        ]);
    }

    private function serialize(array $events): array
    {
        $data = [];
        foreach ($events as $event) {
            $data[] = $event->jsonSerialize();
        }

        return $data;
    }

    private function hydrate(Event $event, array $data): Event
    {
        $event
            ->setTitle($data['title'])
            ->setAdresse($data['adresse'])
            ->setBudget($data['budget'])
            ->setDateDebut($data['date_debut'])
            ->setDateFin($data['date_fin'])
            ->setHeureDebut($data['heure_debut'])
            ->setHeureFin($data['heure_fin'])
            ->setTypeActivite($data['type_activite'])
            ->setNbParticipantMax($data['nb_participant_max'])
            ->setDescription($data['description'])
        ;

        return $event;
    }
}