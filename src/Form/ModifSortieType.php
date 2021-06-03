<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifSortieType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie :',
            ])
            ->add('date_debut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie :',
                'widget' => 'single_text',
                'html5' => true
            ])
            ->add('date_cloture', DateTimeType::class, [
                'label' => 'Date limite d\'inscription :',
                'widget' => 'single_text',
                'html5' => true
            ])
            ->add('nb_inscriptions_max', IntegerType::class, [
                'label' => 'Nombre de places :',
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée en minutes :',
            ])
            ->add('description_infos', TextareaType::class, [
                'label' => 'Description et infos :',
                'attr' => [
                    'rows' => "5",
                ]
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'label' => 'Campus :',
                'choice_label' => 'nomCampus',
                'disabled' => true,
            ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Ville $ville = null)
    {
        $form->add('ville', EntityType::class, [
            'class' => Ville::class,
            'required' => true,
            'mapped' => false,
            'label' => 'Ville :',
            'placeholder' => 'Choisissez une ville',
            'choice_label' => 'nomVille',
        ]);

        $form->add('lieu', EntityType::class, [
            'class' => Lieu::class,
            'required' => true,
            'label' => 'Lieu :',
            'placeholder' => 'Choisissez un lieu',
            'choice_label' => 'nomLieu',
        ]);

        $form->add('Rue', TextType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,]
        ]);
        $form->add('code_postal', TextType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,
            ]
        ]);
        $form->add('latitude', NumberType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,
            ]
        ]);
        $form->add('longitude', NumberType::class, [
            'mapped' => false,
            'attr' => ['readonly' => true,
            ]
        ]);
    }

    function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        $ville = $this->em->getRepository(Ville::class)->find($data['ville']);

        $this->addElements($form, $ville);
    }

    function onPreSetData(FormEvent $event)
    {
        $sortie = $event->getData();
        $form = $event->getForm();

        $ville = $sortie->getLieu() ? $sortie->getLieu()->getVille()  : null;

        $this->addElements($form, $ville);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
