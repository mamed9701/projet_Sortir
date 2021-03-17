<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;

use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('url_photo')
            ->add('nom', null, [
                'label' => 'Nom de la sortie : '
            ])
            ->add('date_debut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie : ',
                'date_widget' => 'single_text'
            ])
            ->add('date_cloture', DateType::class, [
                'label' => "Date limite d'inscription : ",
                'widget' => 'single_text'
            ])
            ->add('nb_inscriptions_max', null, [
                'label' => 'Nombre de places : '
            ])

            ->add('duree', null, [
                'label' => 'Durée : '
            ])
            ->add('description_infos', TextareaType::class, [
                'label' => 'Descritpion et infos : '
            ])

//            ->add('lieux_noLieu', LieuType::class, [
//                'label' => ' '
//            ])

            ->add('lieux_noLieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'label' => 'Lieu'
            ])
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
