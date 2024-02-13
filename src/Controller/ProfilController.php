<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
/*Petit pense bête à usage personnel:
 *
 * Un controller pour chaque type de page.
Une action affiche une vue.

Dans chaque controller:
    - 1 route = 1 action -> méthode */


            // Je suis dans le profil controller

    // 1ère action, je souhaite afficher le profil

            //A. La route
    #[Route('/Participant/details/{id}', name: 'participant_details')]
    public function details(int $id, ParticipantRepository $participantRepository): Response
    {
        $participant = $participantRepository->find($id);

        if(!$participant){
            throw $this->createNotFoundException('Oh no!!!');
        }
        return $this->render('participant/details.html.twig', [
            "profil"=> $participant
        ]);
    }
}