<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    private $rech;
    private $entityManager;
    private $passwordcoder;
    public function __construct(
        UserRepository $rech,
        ManagerRegistry $doctrine,
        UserPasswordHasherInterface $passwordcoder
    ) {
        $this->rech = $rech;
        $this->entityManager = $doctrine->getManager();
        $this->passwordcoder = $passwordcoder;
    }


    #[Route('/inscription', name: 'inscrir')]

    public function inscription(Request $request): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('first');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password_ha = $this->passwordcoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password_ha);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'compte est ajoutée !'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('compte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifier/profil/{id}', name: 'modifier_profile')]

    public function modifierprofile(User $user, Request $request): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password_ha = $this->passwordcoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password_ha);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'compte est ajoutée !'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('utilisateure/modicompte.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
