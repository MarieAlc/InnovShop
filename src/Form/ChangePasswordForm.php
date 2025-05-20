<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as AssertAssert;

class ChangePasswordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword',PasswordType::class,[
                'label'=> 'Ancien mot de passe',
                'mapped'=> false,
                'constraints'=>[
                    new Assert\NotBlank(['message'=>'Veuillez entrer votre mot de passe actuel. ']),
                ],
            ])
            ->add('newPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped'=> false,
                'invalid_message'=> 'Les mots de passe ne correspondent pas.',
                'required' => true,
                'first_options'=>['label'=>'Nouveau mot de passe'],
                'second_options'=>['label' => 'Confirmer le mot de passe'],
                'constraints'=> [
                    new Assert\NotBlank(['message'=>'Veuillez entrer un nouveau mot de passe']),
                    new Assert\Length([
                        'min'=> 6,
                        'minMessage'=> 'Le mot de passe doit contenir au moins {{ limit }} caractères.'
                    ]),
                ],

            ])
            ->add('submit', SubmitType::class,[
                'label'=> 'Changer mon mot de passe'
            ]);

           
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
