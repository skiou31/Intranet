<?php

namespace HEI\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listener = function (FormEvent $event) {
            $data = $event->getData();

            if (!$data) {
                return;
            }

            $ville = $data["ville"];
            $event->getForm()->add('ville', TextType::class, array('data' => $ville));
        };

        $builder
            ->add('civilite',           ChoiceType::class, array(
                'choices' => array(
                    'Madame'   => 'Madame',
                    'Monsieur' => 'Monsieur'
                ),
                'expanded' => true
            ))
            ->add('nom',                TextType::class)
            ->add('prenom',             TextType::class)
            ->add('adresse',            TextType::class)
            ->add('codePostal',         NumberType::class)
            ->add('ville',              ChoiceType::class)
            ->addEventListener(          FormEvents::PRE_SUBMIT, $listener)
            ->add('telephone',          TextType::class)
            ->add('email',              EmailType::class, array(
                'required'  =>  false,
            ))
            ->add('origine',            ChoiceType::class, array(
                'choices'   => array(
                    'Option'              =>  '',
                    'internet'      =>  'internet',
                    'communication' =>  'communication',
                    'presse'        =>  'presse',
                    'foire'         =>  'foire',
                    'sponsor'       =>  'sponsor',
                    'parrainage'    =>  'parrainage',
                    'notoriete'     =>  'notoriete',
                    'autre'         =>  'autre'
                )
            ))
            ->add('origineDetail',      ChoiceType::class, array(
                'required'  =>  false,
                'choices'   =>  array(
                    'Option'            =>  '',
                    'Velux'             => 'velux',
                    'Harnois'           => 'harnois',
                    'combles-fr'        =>  'combles-fr',
                    'centrale'          =>  'centrale',
                    'Annonce Google'    =>  'annonce google',
                    'Internet'          =>  'internet',
                    'Véhicule'          => 'vehicule',
                    'Panneau chantier'  =>  'panneau chantier',
                    'TV avantages'      =>  'tv avantages',
                    'Pages jaunes'      =>  'pages jaunes',
                    'Visite déco'       =>  'visite deco',
                    'Répondeur'         =>  'repondeur',
                    'Ancien client'     =>  'ancien client'
                )
            ))
            ->add('parrain',            TextType::class, array(
                'required'  =>  false
            ))
            ->add('projet',             ChoiceType::class, array(
                'choices'   =>  array(
                    'Projet'        =>  '',
                    'Combles'       =>  'combles',
                    'Caves'         =>  'caves',
                    'Pergolas'      =>  'pergola',
                    'Extension'     =>  'extension',
                    'Rénovation'    =>  'reno',
                    'Surélévation'  =>  'surelevation',
                    'Isolation'     =>  'isolation',
                    'Velux'         =>  'velux'
                )
            ))
            ->add('typeMaison',         ChoiceType::class, array(
                'choices'   =>  array(
                    'Type maison'   =>  '',
                    'Plein pied'    =>  'plein pied',
                    'W'             =>  'W',
                    'Tradi'         =>  'tradi',
                    'Phenix'       =>  'phenix'
                ),
                'required'  =>  false,
            ))
            ->add('anneeConstruction',  NumberType::class, array(
                'required'  =>  false,
            ))
            ->add('commercial',         ChoiceType::class, array(
                'required'  => true,
                'choices'   =>  array(
                    'Commercial'    =>  '',
                    'A définir'     =>  'a definir',
                    'Cyril Frere'   =>  'Cyril',
                    'Lionel Dombrowski'     =>  'Lionel',
                    'Victorien Camicia'     =>  'Victorien',
                    'Adrien Thieffry'       =>  'Adrien',
                    'Dominique Delille'     =>  'Dominique',
                    'Sébastien Hallez'      =>  'Sebastien',
                    'Jérôme Ombrouck'       =>  'Jerome',
                    'Benoit Charpentier'    =>  'Benoit',
                    'Stéphane Hearteaux'    =>  'Stephane'
                )
            ))
            ->add('commentaire',        TextareaType::class, array(
                'required'  =>  false,
            ))
            ->add('Enregistrer',        SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HEI\ContactBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hei_contactbundle_contact';
    }


}
