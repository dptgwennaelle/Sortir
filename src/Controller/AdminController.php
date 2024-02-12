<?php

namespace App\Controller ;

use App\Repository\CampusRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    #[Route('/admin/villes', name: 'admin_villes')]
    public function villes(VilleRepository $villeRepository){

        $villes = $villeRepository->findAll();

        return $this->render('admin/villes.html.twig', [
            'ville' => $villes
        ]);
    }

    #[Route('/admin/campus', name: 'admin_campus')]
    public function campus(CampusRepository $campusRepository){

        $campus = $campusRepository->findAll();

        return $this->render('admin/campus.html.twig', [
            'campus' => $campus
        ]);
    }

}