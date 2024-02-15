<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class, [
                'required' => false,
                'class' => Campus::class,
                'label'=>"Campus : ",
                'choice_label' => 'nom'])
            ->add('nom', TextType::class, ['required' => false,
                'label'=>"Nom : "])
            ->add('dateDebut', DateType::class, ['required' => false,
                'label'=>"Entre : "])
            ->add('dateFin', DateType::class, ['required' => false,
                'label'=>"Et : "])
//            ->add('organisateur', CheckboxType::class, ['required' => false,
//                'label'=>"Sortie dont je suis l'organisateur/trice : "])
//            ->add('participant', CheckboxType::class, ['required' => false,
//                'label'=>"Sorties auxquelles je suis inscrit/e : "])
//            ->add('nonInscrit', CheckboxType::class, ['required' => false,
//                'label'=>"Sortie dont je ne suis pas inscrit/e : "])
//            ->add('sortiePassee', CheckboxType::class, ['required' => false,
//                'label'=>"Sorties passées"])
            ->add('rechercher', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
