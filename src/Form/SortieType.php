<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;

use App\Entity\Ville;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('url_photo')
            ->add('nom', null, [
                'label' => 'Nom de la sortie'
            ])
            ->add('date_debut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie : ',
                'date_widget' => 'single_text',
            ])
            ->add('date_cloture', DateType::class, [
                'label' => "Date limite d'inscription : ",
                'widget' => 'single_text',
                'required' => false
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

            ->add('villes_no_ville', EntityType::class, [
                'class' => Ville::class,
                'placeholder' => 'Sélectionnez une ville',
                'mapped' => false,
                'label' => 'Ville :',
                'required' => false
            ])

            ->add('etats_no_etat', EntityType::class, [
                'class' => Etat::class,
                'label' => 'Etat',
                'choice_label' => 'libelle'
            ])
        ;

        $builder->get('villes_no_ville')->addEventListener(
          FormEvents::POST_SUBMIT,
            function (FormEvent $event)
            {
                $form = $event->getForm();
                $this->addLieuField($form->getParent(), $form->getData());
            });

        $builder->addEventListener(
          FormEvents::POST_SET_DATA,
          function (FormEvent $event){
              $data = $event->getData();
              /* @var $lieu Lieu */
              $lieu = $data->getLieuxNolieu();

              $form = $event->getForm();
              if ($lieu){

                  $ville = $lieu->getVillesNoVille();
                  $this->addLieuField($form, $ville);
                  $form->get('villes_no_ville')->setData($ville);
              }else{
                  $this->addLieuField($form, null);
              }

          }
        );
    }

    private function addLieuField(FormInterface $form, ?Ville $ville){
        $form->add('lieux_noLieu', EntityType::class, [
            'class' => Lieu::class,
            'placeholder' => $ville ? 'Sélectionnez le lieu' : 'Veuillez sélectionner la ville',
            'choices' => $ville ? $ville->getLieu() : [],
            'label' => 'Lieu :'
        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
