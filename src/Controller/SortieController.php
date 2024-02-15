<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\CreateSortieType;
use App\Repository\SortieRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
    ){
        $user = $this->getUser()->getUserIdentifier();
        $sortie = new Sortie();
        $sortie->setOrganisateur($this->getUser());
        $sortieForm = $this->createForm(CreateSortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('sortir_liste', [

            ]);
        }
        return $this->render('sortie/create.html.twig', [
            'sortieForm'=>$sortieForm->createView(),
        ]);
    }

    #[Route('/Sortie/delete/{id}', name: 'sortir_delete', requirements: ["id"=>"\d+"])]
    public function delete(int $id, EntityManagerInterface $entityManager, SortieRepository $sortieRepository){
        $sortie = $sortieRepository->find($id);

        if (!$sortie) {
            throw $this->createNotFoundException('Sortie non trouvée avec l\'id '.$id);
        }

        $sortieList = $sortieRepository->findAll();
        $entityManager->remove($sortie);
        $entityManager->flush();

        return $this->render('sortie/liste.html.twig', [
            'sorties' => $sortieList
        ]);
    }
}