<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Util\ClassUtils;
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

        // Création du formulaire de modification de profil
        $form = $this->createForm(ProfilType::class, $user);

        // Traitement du formulaire avec handleRequest
        $form->handleRequest($request);

        // Si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid())
        {

            if ($user instanceof Participant) {

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->render('profil/display.html.twig', [
                    'participant' => $user
                ]);
            }else{
                return $this->render('profil/display.html.twig');
            }
        }

        // Définir la variable FormProfil dans tous les cas
        return $this->render('profil/profil.html.twig', [
            'FormProfil' => $form->createView(),
            'participant' => $user
        ]);
    }
    #[Route('/profil/display', name: 'app_display')]
    public function display(): Response
    {
        $user = $this->getUser();

        return $this->render('profil/display.html.twig', [
            'participant' => $user
        ]);
    }
}
