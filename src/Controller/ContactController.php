<?php

namespace App\Controller;


use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->json([
            'contacts'=>$this->contactRepository->findAll()
        ]);
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

    // public function add(array $data):Response{

    //     try{
    //         $contact =$this->integration(new Contact(),$data);
    //         $this->contactRepository->add($contact);
    //         return $this->json([
    //             'status'=>'success',
    //             'id'=>$contact->getId(),
    //         ]);
    //     }catch (\Exception $th){
    //         return $this->json([
    //             'status'=>'error',
    //             'id'=>$th->getMessage(),
    //         ]);
    //     }
    // }


}
//postman