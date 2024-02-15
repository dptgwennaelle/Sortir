<?php

namespace App\Controller ;

use App\Form\SearchFormType;
use App\Repository\ParticipantRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/villeliste', name: 'admin_villeliste')]
    public function liste(Request $request,
                          VilleRepository $villeRepository,
                          EntityManagerInterface $entityManager): Response
    {
        $villes = $villeRepository->findAll();
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement des données du formulaire
            $searchTerm = $form->get('search')->getData();
            return $this->render('admin/villeliste.html.twig', [
                'villes' => $villes,
                'form' => $form->createView(),
            ]);}
        return $this->render('admin/villeliste.html.twig', [
            'villes'=>$villes,
            'form'=>$form->createView()
        ]);
    }

    #[Route('/admin/villecreate', name: 'admin_villecreate')]
    public function create(): Response
    {
        return $this->render('admin/villecreate.html.twig.html.twig', [

        ]);
    }
}