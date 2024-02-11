<?php

namespace App\Controller ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    #[Route('/admin/villes', name: 'admin_villes')]
    public function villes(){
        return $this->render('admin/villes.html.twig', [
        ]);
    }

    #[Route('/admin/campus', name: 'admin_campus')]
    public function campus(){
        return $this->render('admin/campus.html.twig', [
        ]);
    }

}