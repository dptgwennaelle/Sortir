<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/Sortie/', name: 'sortir_home')]
 public function home(){
        return $this->render('sortie/home.html.twig', [
        ]);
 }
    #[Route('/Sortie/liste', name: 'sortir_liste')]
    public function liste(SortieRepository $sortieRepository){
        $sortieList = $sortieRepository->findAll();
        return $this->render('sortie/liste.html.twig', [
            'sorties'=>$sortieList
        ]);
    }

    #[Route('/Sortie/create', name: 'sortir_create')]
    public function create(){
        return $this->render('sortie/create.html.twig', [
        ]);
    }

}