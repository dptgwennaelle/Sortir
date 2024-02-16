<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ModificationProfilFormType;
use App\Form\ProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

    #[Route('/profil', name: 'profil_liste')]
    public function liste(ParticipantRepository $participantRepository): Response
    {
        $participantId = $this->getUser()->getUserIdentifier();
        $profil = $participantRepository->findOneByIdentifiant($participantId);
        return $this->render('profil/liste.html.twig', [
            'profil' => $profil
        ]);
    }

    #[Route('/profil/detail/{id}', name: 'profil_detail')]
    public function details(int $id, ParticipantRepository $participantRepository): Response
    {
        $profil = $participantRepository->find($id);
        if (!$profil) {
            throw $this->createNotFoundException('Oh no!!!');
        }
        return $this->render('profil/detail.html.twig', [
            'profil' => $profil
        ]);
    }

    #[Route('/profil/create', name: 'profil_create')]
    public function create(
        Request                $request,
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
            'profilForm' => $profilForm->createView(),
        ]);
    }

    #[Route('/profil/modifier/{id}', name: 'profil_modifier', requirements: ["id" => "\d+"])]
    public function modifier(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request,
        ParticipantRepository $participantRepository,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response {
        $profil = $participantRepository->find($id);

        // Vérifiez que le profil existe bien
        if (!$profil) {
            throw $this->createNotFoundException('Profil non trouvé avec l\'id ' . $id);
        }

        // Créez un formulaire pour le modifier
        $profilModifForm = $this->createForm(ModificationProfilFormType::class, $profil);

        $profilModifForm->handleRequest($request);

        if ($profilModifForm->isSubmitted() && $profilModifForm->isValid()) {
            if ($profilModifForm->get('password')->getData() != null){
            $newPassword = $profilModifForm->get('password')->getData();

            if ($newPassword !== null && $newPassword !== '') {
                $hashedPassword = $userPasswordHasher->hashPassword($profil, $newPassword);
                $profil->setPassword($hashedPassword);
            }}

            $entityManager->persist($profil);
            $entityManager->flush();

            return $this->redirectToRoute('profil_liste');
        }

        return $this->render('profil/modifier.html.twig', [
            'profil' => $profil,
            'profilModifForm' => $profilModifForm->createView()
        ]);
    }

}