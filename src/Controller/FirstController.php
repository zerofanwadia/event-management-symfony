<?php

namespace App\Controller;

use App\Form\RecherchType;
use App\Repository\EventRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FirstController extends AbstractController
{
    private $eventRepository;
    private $entityManager;
    public function __construct(EventRepository $eventRepository,
     ManagerRegistry $doctrine){
        $this->eventRepository=$eventRepository;
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/', name: 'app_first')]
    public function index(EventRepository $eventRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $form = $this->createForm(RecherchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $data = $this->eventRepository->findByFilter($form->getData());
        }else{
            $data=$eventRepository->findBy([], ['id' => 'DESC']);
        }
        $event=$paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

       /* $event=$eventRepository->findBy([], ['id' => 'DESC'], 6);*/
        return $this->render('accueilv.html.twig',['form' => $form->createView(),'event' => $event]);
    }

    #[Route('/prpfile', name:'profile')]

    public function Profile():Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        return $this->render('utilisateure/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

}