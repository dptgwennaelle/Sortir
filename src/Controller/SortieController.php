<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/', name: 'sortir_home')]
    public function home(){
        return $this->render('sortie/home.html.twig', [
        ]);
    }

    /*  #[Route('/', name: 'sortir_home')]
    public function home(){
        return $this->render('sortie/home.html.twig', [
        ]);
    }*/

    // Afficher les détails d'une sortie
    #[Route('/sortie/details/{id}', name: 'app_sortie_details')]
    public function details(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        if(!$sortie){
            throw $this->createNotFoundException('Oh no!!!');
        }
        return $this->render('sortie/details.html.twig', [
            "sortie"=> $sortie
        ]);
    }

    #[Route('/sortie/create', name: 'sortie_create')]
    public function create(Request $request,
                           EntityManagerInterface $entityManager): Response
    {
        $sortie = new Sortie();

        // Pas besoin de setDateCreated car cette méthode n'existe pas dans votre entité Sortie

        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'Sortie ajoutée avec succès !');
            return $this->redirectToRoute('sortie_details', ['id' => $sortie->getId()]);
        }

        return $this->render('sortie/create.html.twig', [
            'sortieForm' => $sortieForm->createView()
        ]);
    }

    #[Route('/sortie/delete/{id}', name: 'sortie_delete')]
    public function delete(Sortie $sortie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($sortie);
        $entityManager->flush();
        return $this->redirectToRoute('main_home');

    }

}