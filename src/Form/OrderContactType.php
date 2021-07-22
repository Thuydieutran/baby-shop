<?php

namespace App\Form;

use App\Entity\OrderContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OrderContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', EmailType::class, [
                'label' => 'E-mail :',
                'label_attr' => [
                    'class' => 'h5',
                ],
                'attr' => [
                    'placeholder' => 'Votre e-mail',
                ]
            ])
           
            ->add('message', TextareaType::class, [
                'label' => 'Message :',
                'label_attr' => [
                    'class' => 'h5',
                ],
                'attr' => [
                    'placeholder' => 'Votre message',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderContact::class,
        ]);
    }
}