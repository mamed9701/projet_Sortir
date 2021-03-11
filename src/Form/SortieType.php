<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use function Symfony\Bridge\Twig\Extension\twig_is_selected_choice;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url_photo')
            ->add('nom', null, [
                'label' => 'Nom de la sortie : '
            ])
            ->add('date_debut', null, [
                'label' => 'Date et heure de la sortie : '
            ])
            ->add('date_cloture', DateType::class, [
                'format' => 'dd-MM-yyyy',
                'label' => "Date limite d'inscription : "
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

            ->add('site_organisateur', EntityType::class, [
                'label' => 'Ville organisatrice : ',
                'class' => Site::class,

            ])
//            ->add('organisateur')

            ->add('lieux_no_lieu', LieuType::class)

//            ->add('lieux_no_lieu', null, [
//                'label' => 'Rue',
//                'choice_label' => function(Lieu $lieu) {
//                    return sprintf('%s', $lieu->getRue());
//                }
//            ])

            ->add('lieux_no_lieu', null, [
                'label' => 'Lieu',
                'choice_label' => 'Lieu'
            ])

            ->add('etats_no_etat', null, [
                'choice_label' => 'libelle'
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
