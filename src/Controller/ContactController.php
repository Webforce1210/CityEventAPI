<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    public function __construct(private ContactRepository $contactRepository)
    {
        
    }
    /**
     * @Route("/contact", name="app_contact", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json($this->serialize($this->contactRepository->findAll()));
    }

        /**
     * @Route("/contact/{id}", name="app_contact_show", methods={"GET"})
     */
    public function show(int $id):Response{
        return $this->json([
            'contact'=>$this->contactRepository->find($id)
        ]);
    }

        /**
     * @Route("/contact/add", name="app_contact_add", methods={"POST"})
     */

    private function serialize(array $contacts): array
    {
        $data = [];
        foreach ($contacts as $contact) {
            $data[] = $contact->jsonSerialize();
        }

        return $data;
    }
}
//postman