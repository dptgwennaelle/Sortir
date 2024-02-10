<?php

namespace App\Controller;

use App\Form\ProfilType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'user actuellement connecté
        $user = $this->getUser();

        //Création du formulaire de modification de profil
        $form = $this->createForm(ProfilType::class, $user);

        //Traitement du formulaire avec handleRequest
        $form->handleRequest($request);

        /* if ($form->isSubmitted() && $form->isValid())
         {
             $entityManager->persist($user);
             $entityManager->flush();

             return $this->render('profil/profil.html.twig');
         }*/

        return $this->render('profil/profil.html.twig', [
            'FormProfil' => $form->createView(),
        ]);
    }
}
