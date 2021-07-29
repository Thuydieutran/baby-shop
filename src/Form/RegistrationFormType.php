<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom :',
            'label_attr' => [
                'class' => 'h5',
            ],
            'attr' => [
                'placeholder' => 'Anna',
            ]
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom :',
            'label_attr' => [
                'class' => 'h5',
            ],
            'attr' => [
                'placeholder' => 'Jolie',
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'E-mail :',
            'label_attr' => [
                'class' => 'h5',
            ],
            'attr' => [
                'placeholder' => 'email@gmail.com',
            ]
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'label' => 'Accepter les ',
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'Veuillez accepter les conditions d\'utilisation',
                ]),
            ],
        ])

        ->add('plainPassword', PasswordType::class, [
            'label' => 'Mot de passe :',
            'label_attr' => [
                'class' => 'h5',
            ],
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez indiquer un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                    'max' => 4096,
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
