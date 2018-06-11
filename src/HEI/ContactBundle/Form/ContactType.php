<?php

namespace HEI\ContactBundle\Form;

use HEI\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
        $currentDate = new \DateTime();

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
                    'Velux'         =>  'velux',
                    'Trappe cave'   =>  'trappe cave'
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
            ->add('commercial',         EntityType::class, array(
                'class'  => User::class,
                'choice_label'  =>  'nom'
            ))
            ->add('rendezVous',         DateTimeType::class, array(
                'date_format'   =>  'dd/MM/yyyy',
                'placeholder' => array(
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute'
                ),
                'years' =>  array(
                    $currentDate->format('Y'),
                    $currentDate->format('Y')+1
                ),
                'hours' =>  array(
                    '07','08','09','10','11','12','13','14','15','16','17','18','19'
                ),
                'minutes'   =>  array(
                    '00',
                    '15',
                    '30',
                    '45'
                ),
                'required'  =>  true
            ))
            ->add('PS',                 TextareaType::class, array(
                'required'  =>  false
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
