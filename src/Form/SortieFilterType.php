<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\SortieSearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomCampus', EntityType::class, [
                'class' => Campus::class,
                'label' => 'Campus :',
                'choice_label' => 'nom_campus'
            ])

            ->add('motCle', SearchType::class, [
                'label' => 'Le nom de la sortie contient : ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])

            ->add('dateDebutSearch', DateTimeType::class, [
                'label' => 'Entre le :',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('dateFinSearch', DateTimeType::class, [
                'label' => ' et le :',
                'required' => false,
                'widget' => 'single_text',

            ])

            ->add('sortieOrganisateur', CheckboxType::class, [
                'label' =>  'Sorties dont je suis organisateur',
                'required' => false,

            ])

            ->add('sortieInscrit', CheckboxType::class, [
                'label' =>  'Sorties auxquelles je suis inscrit/e',
                'required' => false,
            ])

            ->add('sortieNonInscrit', CheckboxType::class, [
                'label' =>  'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
            ])

            ->add('sortiePassees', CheckboxType::class, [
                'label' =>  'Sorties passées',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SortieSearchData::class,

        ]);
    }
}
