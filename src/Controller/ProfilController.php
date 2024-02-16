<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Wish;
use App\Form\ProfilType;
use App\Form\WishFormType;
use App\Repository\ParticipantRepository;
use App\Repository\WishRepository;
use App\Service\Censurator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

    #[Route('/profil', name: 'profil_liste')]
    public function liste(ParticipantRepository $participantRepository): Response
    {
        $participantId = $this->getUser()->getUserIdentifier();
        $profil = $participantRepository->findOneByIdentifiant($participantId);
        return $this->render('profil/liste.html.twig', [
            'profil'=>$profil
        ]);
    }
    #[Route('/profil/detail/{id}', name: 'profil_detail')]
    public function details(int $id, ParticipantRepository $participantRepository): Response
    {
        $profil = $participantRepository->find($id);
        if (!$profil){
            throw $this->createNotFoundException('Oh no!!!');
        }
        return $this->render('profil/detail.html.twig', [
            'profil'=>$profil
        ]);
    }
    #[Route('/profil/create', name: 'profil_create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $profil = new Participant();
        $profilForm = $this->createForm(ProfilType::class, $profil);

        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()) {
            $entityManager->persist($profil);
            $entityManager->flush();

            //$this->addFlash('Succès', 'Voeux ajouté, bien joué!');
            return $this->redirectToRoute('profil_liste', ['id' => $profil->getId()]);
        }
        return $this->render('profil/create.html.twig', [
            'profilForm'=>$profilForm->createView(),
        ]);
    }

}