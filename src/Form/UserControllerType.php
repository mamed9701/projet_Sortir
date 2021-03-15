<?php

namespace App\Form;

use App\Entity\UserController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserControllerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                'label' => 'email'
            ])
//            ->add('roles')
            ->add('password', null, [
                'data' => ''
            ])
            ->add('nom', null, [
            ])
            ->add('prenom', null, [])
            ->add('pseudo', null, [])
            ->add('telephone', null, [])
//            ->add('actif')
//            ->add('url_photo')
            ->add('site', SiteType::class, [
                'label' => ' '
            ])
//            ->add('user_sortie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserController::class,
        ]);
    }
}
