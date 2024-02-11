<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Util\ClassUtils;
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

    #[Route('/test', name: 'sortir_test')]
    public function test(){
        return $this->render('sortie/test.html.twig', [
        ]);
    }

}