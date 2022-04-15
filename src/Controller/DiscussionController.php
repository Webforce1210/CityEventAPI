<?php

namespace App\Controller;

use App\Entity\Discussion;
use App\Repository\DiscussionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscussionController extends AbstractController
{
    public function __construct(private DiscussionRepository $discussionRepository)
    {
        
    }

        /**
     * @Route("/discussion", name="app_discussion", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json($this->serialize($this->discussionRepository->findAll())
        );
    }

        /**
     * @Route("/discussion-{id}", name="app_discussion_show", methods={"GET"})
     */
    public function show(int $id):Response{
        return $this->json([
            'discussion'=>$this->discussionRepository->find($id)->jsonSerialize()
        ]);
    }


        /**
     * @Route("/discussion/add", name="app_discussion_add", methods={"POST"})
     */
    public function add(Request $request):Response{
        try{
            $data=$request->request->all();
            $discussion = $this->hydrate(new Discussion(),$data);
            $this->discussionRepository->add($discussion);

            return $this->json([
                'status'=>'success',
                'id'=>$discussion->getId(),
            ]);
        }catch(\Exception $th){
            return $this->json([
                'status'=>'error',
                'message'=>$th->getMessage(),
            ],500);
        }
    }

        /**
     * @Route("/discussion/{id}/update", name="app_discussion_update", methods={"POST"})
     */
    public function update(int $id,Request $request):Response
    {
        $discussion=$this->discussionRepository->find($id);

        if(null === $discussion){
            return $this->json([
                'status'=>'error',
                'message'=>'Discussion not found'
            ],404);
        }

        try{
            $data =$request->request->all();
            $discussion =$this->hydrate($discussion,$data);
            $this->discussionRepository->add($discussion);

            return $this->json([
                'status'=>'success',
                'id'=>$discussion->getId(),
            ]);
        }catch(\Exception $th){
            return $this->json([
                'status'=>'error',
                'message'=>$th->getMessage(),
            ]);
        }
    }

        /**
     * @Route("/discussion/{id}/delete", name="app_discussion_delete", methods={"POST"})
     */
    public function delete(int $id):Response{
        $discussion = $this->discussionRepository->find($id);

        if(null === $discussion){
            return $this->json([
                'status'=>'error',
                'message'=>'Discussion not found'
            ],404);
        }else{
            $this->discussionRepository->remove($discussion);
        }

        return $this->json([
            'status'=>'success'
        ]);
    } 


    private function serialize(array $discussions): array
    {
        $data = [];
        foreach ($discussions as $discussion) {
            $data[] = $discussion->jsonSerialize();
        }

        return $data;
    }

    private function hydrate(Discussion $discussion,array $data):Discussion{
        $discussion
            ->setNameDiscussion($data['name_discussion'])
            ->setAvatar($data['avatar'])
            ->setLastMessage($data['last_message']);
            return $discussion;
    }
}
