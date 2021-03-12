<?php

namespace App\Form;

use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', EntityType::class, [
                'label' => 'Ville',
                'class' => Ville::class,
//                'query_builder' => function (EntityRepository $er) {
//                    return $er->createQueryBuilder('l')
//                        ->select('l.nom')
//                        ->where('l.lieux_no_lieu.organisateur.id =:app.user.id')
//                        ->orderBy('l.nom', 'ASC');
//                },
                'choice_label' => 'nom',
            ])
            ->add('code_postal', null, [
                'disabled' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
