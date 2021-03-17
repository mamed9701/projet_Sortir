<?php

namespace App\Form;

use App\Entity\Lieu;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'choice_value' => function (?Lieu $entity) {
                    return $entity ?  $entity->getNom() : '';
                },
                'class' => Lieu::class
            ])
            ->add('send', ButtonType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ],
                'label' => ' + '
            ])
            ->add('rue', null, [
            ])
            ->add('latitude')
            ->add('longitude');

//        $builder->get('nom')
//            ->addModelTransformer(new CallbackTransformer(
//                function ($objectToString) {
//                    // transform the object to a string
//                    return $objectToString;
//                },
//                function (Lieu $StringToObject) {
//                    return $StringToObject->getNom();
//                }
//            ))
//        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
