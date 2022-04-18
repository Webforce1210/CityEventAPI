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

    public function add(Request $request):Response{
        try{
            $data=$request->request->all();
            $contact=$this->hydrate(new Contact(),$data);
            $this->contactRepository->add($contact);
            return $this->json([
                'status'=>'succes',
                'id'=>$contact->getId(),
            ]);
        }catch(\Exception $th){
            return $this->json([
                'status'=>'error',
                'message'=>$th->getMessage(),
            ],500);
        }
    }


            /**
     * @Route("/contact/{id}/update", name="app_contact_update", methods={"POST"})
     */

    public function update(int $id,Request $request):Response
    {
        $contact=$this->contactRepository->find($id);

        if(null === $contact){
            return $this->json([
                'status'=>'error',
                'message'=>'contact not found'
            ],404);
        }

        try{
            $data =$request->request->all();
            $contact =$this->hydrate($contact,$data);
            $this->contactRepository->add($contact);

            return $this->json([
                'status'=>'success',
                'id'=>$contact->getId(),
            ]);
        }catch(\Exception $th){
            return $this->json([
                'status'=>'error',
                'message'=>$th->getMessage(),
            ]);
        }
    }

            /**
     * @Route("/contact/{id}/delete", name="app_contact_delete", methods={"POST"})
     */

    public function delete(int $id):Response{
        $contact = $this->contactRepository->find($id);

        if(null === $contact){
            return $this->json([
                'status'=>'error',
                'message'=>'contact not found'
            ],404);
        }else{
            $this->contactRepository->remove($contact);
        }

        return $this->json([
            'status'=>'success'
        ]);
    } 



    private function serialize(array $contacts): array
    {
        $data = [];
        foreach ($contacts as $contact) {
            $data[] = $contact->jsonSerialize();
        }

        return $data;
    }

    private function hydrate(Contact $contact,array $data):Contact{
        $contact
            ->setProp($data['prop']);
            return $contact;
    } 
}
//postman