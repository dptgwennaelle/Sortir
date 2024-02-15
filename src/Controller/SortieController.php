<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\CreateSortieType;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
        $entityManager->remove($sortie);
        $entityManager->flush();
        $sortieList = $sortieRepository->findAll();

        return $this->render('sortie/liste.html.twig', [
            'sorties' => $sortieList
        ]);
    }

    #[Route('/Sortie/inscrire/{id}', name: 'sortir_inscrire', requirements: ["id"=>"\d+"])]
    public function inscrire(
        int $id,
        EntityManagerInterface $entityManager,
        SortieRepository $sortieRepository,
        ParticipantRepository $participantRepository
    ) {
        $sortie = $sortieRepository->find($id);

        if (!$sortie) {
            throw $this->createNotFoundException('Sortie non trouvée avec l\'id ' . $id);
        }

        $user = $this->getUser();
        $participant = $participantRepository->findOneBy(['id' => $user]);

        if (!$participant) {
            throw $this->createNotFoundException('Participant non trouvé pour l\'utilisateur actuel');
        }

        $sortie->addPersonnesInscrite($participant);
        $participant->addListeSortiesDuParticipant($sortie);

        $entityManager->flush();

        $sortieList = $sortieRepository->findAll();

        return $this->render('sortie/liste.html.twig', [
            'sorties' => $sortieList
        ]);
    }

    #[Route('/Sortie/desister/{id}', name: 'sortir_desister', requirements: ["id"=>"\d+"])]
    public function desister(
        int $id,
        EntityManagerInterface $entityManager,
        SortieRepository $sortieRepository,
        ParticipantRepository $participantRepository
    ) {
        $sortie = $sortieRepository->find($id);

        if (!$sortie) {
            throw $this->createNotFoundException('Sortie non trouvée avec l\'id ' . $id);
        }

        $user = $this->getUser();
        $participant = $participantRepository->findOneBy(['id' => $user]);

        if (!$participant) {
            throw $this->createNotFoundException('Participant non trouvé pour l\'utilisateur actuel');
        }
        $participantDansLaSortie = $sortie->getPersonnesInscrites();
        $listeDesSortiesDuParticipant = $participant->getListeSortiesDuParticipant();

        if ($participantDansLaSortie->contains($participant)) {
            $participantDansLaSortie->removeElement($participant);
        }

        if ($listeDesSortiesDuParticipant->contains($sortie)) {
            $listeDesSortiesDuParticipant->removeElement($sortie);
        }
        $entityManager->flush();

        $sortieList = $sortieRepository->findAll();

        return $this->render('sortie/liste.html.twig', [
            'sorties' => $sortieList
        ]);
    }

    #[Route('/Sortie/details/{id}', name:'sortir_details')]
    public function details(int $id, SortieRepository $sortieRepository, LieuRepository $lieuRepository,
                            ParticipantRepository $participantRepository, VilleRepository $villeRepository)
    {
        $sortie = $sortieRepository->find($id);
        // Vérification de l'existence de la sortie
        if (!$sortie) {
            throw $this->createNotFoundException('Sortie non trouvée');
        }
        // Code pour récupérer les détails de la sortie, y compris le lieu associé
        $lieu = $sortie->getLieu();
        $ville = $lieu->getVille();
        $personnesInscrites = $participantRepository->findBySortie($sortie);

        return $this->render('sortie/details.html.twig', [
            'sortie' => $sortie,
            'lieu' => $lieu,
            'ville'=>$ville,
            'personnesInscrites' => $personnesInscrites,
        ]);
    }
}