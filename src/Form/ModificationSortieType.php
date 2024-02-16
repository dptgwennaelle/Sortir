<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModificationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class, [
                'required' => false,
                'class' => Campus::class,
                'label' => "Campus : ",
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('nom', TextType::class, [
                'required' => false,
                'label' => "Nom : ",
                'attr' => ['class' => 'form-control'],
            ])

            ->add('dateDebut', DateType::class, [
                'required' => false,
                'label' => "Entre : ",
                'attr' => ['class' => 'form-control'],
            ])

            ->add('dateFin', DateType::class, [
                'required' => false,
                'label' => "Et : ",
                'attr' => ['class' => 'form-control'],
            ])

            ->add('organisateur', CheckboxType::class, [
                'required' => false,
                'label' => "Sortie dont je suis l'organisateur/trice : ",
                'attr' => ['class' => 'form-check-input'],
            ])

            ->add('participant', CheckboxType::class, [
                'required' => false,
                'label' => "Sorties auxquelles je suis inscrit/e : ",
                'attr' => ['class' => 'form-check-input'],
            ])

            ->add('nonInscrit', CheckboxType::class, [
                'required' => false,
                'label' => "Sortie dont je ne suis pas inscrit/e : ",
                'attr' => ['class' => 'form-check-input'],
            ])

            ->add('sortiePassee', CheckboxType::class, [
                'required' => false,
                'label' => "Sorties passées",
                'attr' => ['class' => 'form-check-input'],
            ])

            ->add('rechercher', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
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
