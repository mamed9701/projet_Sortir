<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom de la sortie'
            ])
            ->add('date_debut', null, [
                'label' => 'Date et heure de la sortie'
            ])

            ->add('duree')
            ->add('date_cloture', DateType::class, [
                'format' => 'dd-MM-yyyy'
            ])
            ->add('nb_inscriptions_max')
            ->add('description_infos')
            ->add('url_photo')
            ->add('organisateur')
            ->add('lieux_no_lieu')
            ->add('site_organisateur', null, [
                'choice_label' => 'nom'
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
