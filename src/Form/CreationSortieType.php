<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Ville;
use App\Entity\Participant;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree', null, [
                'label'=>"Durée (en minutes) :"
            ])
            ->add('dateLimiteInscription')
            ->add('nbInscriptionsMax')
            ->add('infosSortie')
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'libelle',
            ])

            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])

            ->add('nom', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'label'=>'Ville'
            ])

        ->add('lieu', EntityType::class, [
        'class' => Lieu::class,
        'choice_label' => 'nom',
        'label'=>'Lieux'
    ]);

            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){

                $form = $event->getForm();
                $data = $event->getData();

                // Si vous avez besoin de pré-remplir les données
                $ville = null;
                if ($data instanceof Sortie) {
                    $ville = $data->getLieu() ? $data->getLieu()->getVille() : null;
                }

                $this->setupLieuField($form, $ville);
            });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            // Obtenez la ville soumise
            $villeId = $data['ville'] ?? null;

            // Si vous avez besoin de pré-remplir les données
            $ville = null;
            if ($villeId !== null) {
                $ville = $this->entityManager->getRepository(Ville::class)->find($villeId);
            }

            $this->setupLieuField($form, $ville);
        });
    }

    private function setupLieuField(FormInterface $form, ?Ville $ville): void
    {
        $lieux = [];
        if ($ville !== null) {
            // Récupérez les lieux associés à la ville sélectionnée
            $lieux = $this->entityManager->getRepository(Lieu::class)->findBy(['id_ville' => $ville->getId()]);
        }

        $form->add('lieu', EntityType::class, [
            'class' => Lieu::class,
            'choice_label' => 'nom',
            'label' => 'Lieux',
            'required' => false,
            'placeholder' => 'Sélectionnez un lieu',
            'choices' => $lieux, // Utilisez les lieux filtrés en fonction de la ville sélectionnée
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
