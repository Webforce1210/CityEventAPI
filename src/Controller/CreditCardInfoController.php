<?php

namespace App\Controller;

use App\Entity\CreditCardInfo;
use App\Repository\CreditCardInfoRepository;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditCardInfoController extends AbstractController



{
    
      
    
    public function __construct(
        private CreditCardInfoRepository $creditCardInfoRepository
    ) {



    }
    

    /**
     * @Route("/creditcardinfo", name="app_cc", methods={"GET"})
     */
    public function CCInfo() :Response
    {

       return $this->json($this->serialize($this->creditCardInfoRepository->findAll()));


  
    }


    /**
     * @Route("/creditcardinfo/{id}", name="app_cc_show", methods={"GET"})
     */
    public function show(int $id): Response
    {

        return $this->json([
            'creditcard' => $this->creditCardInfoRepository->find($id)->jsonSerialize(),
        ]);
    
       
    }

    /**
     * @Route("/creditcardinfo/add", name="app_cc_add", methods={"POST"})
     */
    public function add(array $data): Response
    {
        try {
            $creditcard = $this->hydrate(new CreditCardInfo(), $data);
            $this->creditCardInfoRepository->add($creditcard);

            return $this->json([
                'status' => 'success',
                'id' => $creditcard->getId(),
            ]);
        } catch (\Exception $th) {
            return $this->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/creditcardinfo/{id}/update", name="app_cc_update", methods={"POST"})
     */
    public function update(array $data, int $id): Response
    {
        $creditcard = $this->creditCardInfoRepository->find($id);

        if (null === $creditcard) {
            return $this->json([
                'status' => 'error',
                'message' => 'Card not found',
            ], 404);
        }

        try {
            $creditcard = $this->hydrate($creditcard, $data);
            $this->creditCardInfoRepository->add($creditcard);

            return $this->json([
                'status' => 'success',
                'id' => $creditcard->getId(),
            ]);
        } catch (\Exception $th) {
            return $this->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/creditcardinfo/{id}/delete", name="app_cc_delete", methods={"POST"})
     */
    public function delete(int $id): Response
    {
        $creditcard = $this->creditCardInfoRepository->find($id);

        if (null === $creditcard) {
            return $this->json([
                'status' => 'error',
                'message' => 'Card not found',
            ], 404);
        } else {
            $this->creditCardInfoRepository->remove($creditcard);
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
    private function hydrate(CreditCardInfo $creditcard, array $data): CreditCardInfo
    {
        $creditcard
            ->setNumCarte($data['num_carte'])
            ->setDateExpi($data['date_expi'])
            ->setCvc($data['cvc'])
            ->setNomPrenom($data['nom_prenom'])
            ->setUser($data['user']);



        return $creditcard;
    }
}


