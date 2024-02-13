<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Util\ClassUtils;
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

    #[Route('/create', name: 'sortir_create')]
    public function create(Request $request, EntityManagerInterface $entityManager, SortieRepository $sortieRepository): Response
    {
        $sortie = new Sortie();

        $villes = $sortieRepository->findVilles();

        $form = $this->createForm(SortieType::class, $sortie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
                $entityManager->persist($sortie);
                $entityManager->flush();

                return $this->render('profil/display.html.twig');
        }

        // Définir la variable FormSortie dans tous les cas
        return $this->render('sortie/create.html.twig', [
            'FormSortie' => $form->createView(),
            'villes' => $villes,
        ]);
    }

}