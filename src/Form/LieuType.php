<?php

namespace App\Form;

use App\Entity\Lieu;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('villes_no_ville', VilleType::class, [
                'label' => ' '
            ])
            ->add('nom', EntityType::class, [
                'label' => 'Lieu',
                'choice_label' => 'nom',
                'class' => Lieu::class
            ])
            ->add('send', ButtonType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ],
                'label' => ' + '
            ])
            ->add('rue', null, [
                'disabled' => true
            ])
            ->add('latitude')
            ->add('longitude')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
