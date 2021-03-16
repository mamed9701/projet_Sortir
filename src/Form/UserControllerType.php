<?php

namespace App\Form;

use App\Entity\UserController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserControllerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', null, [])
            ->add('prenom', null, [])
            ->add('nom', null, [])
            ->add('telephone', null, [])
            ->add('email', null, [
                'label' => 'email'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Veuiller retaper votre mot de passe',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe',
                ],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])
//            ->add('password', null, [
//                'data' => ''
//            ])
            ->add('site', SiteType::class, [
                'label' => ' '
            ])
//            ->add('url_photo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserController::class,
        ]);
    }
}
