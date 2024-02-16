<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModificationProfilFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder



            ->add('identifiant', TextType::class,
                ['required'=>false,
                    'label' => "Identifiant : "
                ])

            ->add('telephone', TextType::class,
                ['required'=>false,
                    'label' => "Téléphone : "
                ])

            ->add('mail',TextType::class,
                ['required'=>false,
                    'label' => "Email : "
                ])
            ->add('password', PasswordType::class,
                ['required'=>false,
                    'label' => "Mot de passe : "
                ])

//            ->add('Valider', SubmitType::class, [
//                'attr' => ['class' => 'btn btn-primary'],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}