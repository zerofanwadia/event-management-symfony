<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    private $eventRepository;
    private $entityManager;
    public function __construct(EventRepository $eventRepository,
     ManagerRegistry $doctrine){
        $this->eventRepository=$eventRepository;
        $this->entityManager = $doctrine->getManager();
    }


    #[Route('/event', name: 'app_event')]
    public function event(Request $request): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $event= new Event();
        $event->setUser($this->getUser());

        $form=$this->createForm(EventType::class,$event);
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            $event=$form->getData();
            if($request->files->get('event')['image']){
                $image=$request->files->get('event')['image'];
                $image_name=time().'_'.$image->getClientOriginalName();
                $image->move( $this->getParameter('image_directory'),$image_name );
                $event->setImage($image_name);
            }
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'L\'événement a été ajouter'
            );
            return $this->redirectToRoute('app_first');
        }

        return $this->renderForm('utilisateure/creerev.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/event/{id}', name: 'show_event')]

    public function aficheevent($id): Response
    {
         $event=$this->eventRepository->find($id);
    if (!$event) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }
        return $this->render('showev.html.twig',[
            "event"=>$event
        ]);
    }

    #[Route('/Vos_événement', name:'vos_event')]

    public function Vos_événement(): Response
    {
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_login');
    }
        return $this->render('utilisateure/vosev.html.twig',[
            "user"=>$this->getUser(),
        ]);
    }

    #[Route('/Vos_événement/edite/{id}', name:'vos_event_edite')]

    public function Vos_événement_edite(Event $event,Request $request): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        $event->setUser($this->getUser());

        $form=$this->createForm(EventType::class,$event);
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            $event=$form->getData();
            if($request->files->get('event')['image']){
                $image=$request->files->get('event')['image'];
                $image_name=time().'_'.$image->getClientOriginalName();
                $image->move( $this->getParameter('image_directory'),$image_name );
                $event->setImage($image_name);
            }
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'L\'événement a été ajouter'
            );
            return $this->redirectToRoute('app_first');
        }

        return $this->renderForm('utilisateure/editev.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/Vos_événement/delet/{id}', name:'vos_event_delet')]

    public function deletElement(Event $event):Response
    {

            
            $this->entityManager->remove($event);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'LA SUPPRITION EST SUCCESS'
            );
            return $this->redirectToRoute('vos_event');
        

    }
    

}
