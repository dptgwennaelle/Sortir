<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie'
            ])
            ->add('dateHeureDebut', \DateTimeType::class, [
                'label' => 'Date et heure de la sortie'
            ])

            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date limite d\'inscription'
            ])
            ->add('duree', TimeType::class, [
                'label' => 'Durée'
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => 'Nombre de places : '
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Description et infos : '
            ])
            ->add('listesSorties', EntityType::class, [
                'class' => Campus::class,
'choice_label' => 'id',
                'label' => 'Campus '
            ])
            ->add('sorties', EntityType::class, [
                'class' => Etat::class,
'choice_label' => 'id',
            ])
            ->add('sortie', EntityType::class, [
                'class' => Lieu::class,
'choice_label' => 'id',
            ])
            ->add('listeSortiesOrganisees', EntityType::class, [
                'class' => Participant::class,
'choice_label' => 'id',
            ])
            ->add('listeSortiesDuParticipant', EntityType::class, [
                'class' => Participant::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('personnesInscrites', EntityType::class, [
                'class' => Participant::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
