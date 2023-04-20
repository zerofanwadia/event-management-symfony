<?php

namespace App\Controller;

use App\Entity\Clent;
use App\Entity\Event;
use App\Entity\Reserve;
use App\Repository\ClentRepository;
use App\Repository\ReserveRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservController extends AbstractController
{
    private $eventRepository;
    private $entityManager;
    public function __construct(ClentRepository $eventRepository,
     ManagerRegistry $doctrine){
        $this->eventRepository=$eventRepository;
        $this->entityManager = $doctrine->getManager();
    }
    #[Route('/reserv/{id}', name: 'app_reserv')]
    public function reserve(Event $event): Response
    {
        $reserve = new Reserve;
        $reserve->setUser($this->getUser());
        $reserve->setEvent($event);
        $client=new Clent;
        $client->setReserv($reserve);
        $client->setEvent($event);
        $client->setEmail($reserve->getUser()->getEmail());
        $client->setUsername($reserve->getUser()->getUsername());
        $this->entityManager->persist($reserve);
        $this->entityManager->persist($client);
        $this->entityManager->flush();
        $this->addFlash(
            'success',
            'L\'événement a été ajouter'
        );
        return $this->render('utilisateure/vore.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
    #[Route('/Vos_reservation', name:'vos_reservation')]

    public function reservarion():Response
    {

        return $this->render('utilisateure/vore.html.twig', [
            'user' => $this->getUser(),
        ]);

    }

    #[Route('/Vos_reservation/delet/{id}', name:'vos_reserve_delet')]

    public function deletreserve(Reserve $reserve):Response
    {

            
            $this->entityManager->remove($reserve);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'LA SUPPRITION EST SUCCESS'
            );
            return $this->redirectToRoute('vos_reservation');
        

    }

    #[Route('/client', name:'client')]

    public function Client():Response
    {

        $client=$this->eventRepository->findAll();

            return $this->render('utilisateure/clent.html.twig', [
                'user' => $this->getUser(),'client' => $client,
            ]);
        

    }

}
