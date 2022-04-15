<?php

namespace App\Controller;

use App\Entity\MessagePrive;
use App\Repository\MessagePriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        /**
     * @Route("/messagepv-{id}", name="app_messageprive_show", methods={"GET"})
     */
    public function  show(int $id):Response{
        return $this->json([
            'messagepv'=>$this->messagePriveRepository->find($id)->jsonSerialize()
        ]);
        
    }

        /**
     * @Route("/messagepv/add", name="app_messageprive_add", methods={"POST"})
     */
    public function add(Request $request):Response{
        try{
            $data=$request->request->all();
            $messagePrive=$this->hydrate(new MessagePrive(),$data);
            $this->messagePriveRepository->add($messagePrive);

            return $this->json([
                'status'=>'success',
                'id'=>$messagePrive->getId(),
            ]);
        }catch(\Exception $th){
            return $this->json([
                'status'=>'error',
                'message'=>$th->getMessage(),
            ],500);
        }
    }

        /**
     * @Route("/messagepv/{id}/update", name="app_messageprive_update", methods={"POST"})
     */

    public function update(int $id,Request $request):Response
    {
        $messagePrive=$this->messagePriveRepository->find($id);

        if(null === $messagePrive){
            return $this->json([
                'status'=>'error',
                'message'=>'Discussion not found'
            ],404);
        }

        try{
            $data =$request->request->all();
            $messagePrive =$this->hydrate($messagePrive,$data);
            $this->messagePriveRepository->add($messagePrive);

            return $this->json([
                'status'=>'success',
                'id'=>$messagePrive->getId(),
            ]);
        }catch(\Exception $th){
            return $this->json([
                'status'=>'error',
                'message'=>$th->getMessage(),
            ]);
        }
    }

        /**
     * @Route("/messagepv/{id}/delete", name="app_messageprive_delete", methods={"POST"})
     */
    public function delete(int $id):Response{
        $messagePrive = $this->messagePriveRepository->find($id);

        if(null === $messagePrive){
            return $this->json([
                'status'=>'error',
                'message'=>'Discussion not found'
            ],404);
        }else{
            $this->messagePriveRepository->remove($messagePrive);
        }

        return $this->json([
            'status'=>'success'
        ]);
    } 

    private function serialize(array $messageprives): array
    {
        $data = [];
        foreach ($messageprives as $messagepv) {
            $data[] = $messagepv->jsonSerialize();
        }

        return $data;
    }
    private function hydrate(MessagePrive $messagePrive,array $data):MessagePrive{
        $messagePrive
            ->setMessage($data['message'])
            ->setdate($data['date']);
            return $messagePrive;
    }
}
