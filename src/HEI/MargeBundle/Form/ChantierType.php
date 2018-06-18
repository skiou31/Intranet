<?php

namespace HEI\MargeBundle\Form;

use HEI\ContactBundle\Entity\Contact;
use HEI\UserBundle\Entity\User;
use HEI\MargeBundle\Entity\Equipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\NumberToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use HEI\MargeBundle\Form\ChampSuppType;

class ChantierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentDate = new \DateTime();
        $contact = $options['contact'];
        $commercial = $contact->getCommercial();

        $builder
            ->add('contact',                            TextType::class, array(
                'data'  =>  $contact->getNom(),
                'disabled'  =>  true
            ))
            ->add('typeChantier',                       ChoiceType::class, array(
                'choices'   =>  array(
                    'TRADI'     =>  'TRADI',
                    'W'         =>  'W',
                    '2eme Niv'  =>  '2eme Niv',
                    'Pré-amen'  =>  'Pré-amen',
                    'Velux'     =>  'Velux'
                )
            ))
            ->add('dateDebut',                          DateType::class, array(
                'widget'    =>  'choice',
                'format'    =>  'dd/MM/yyyy',
                'years' =>  array(
                    $currentDate->format('Y'),
                    $currentDate->format('Y')+1
                ),
            ))
            ->add('dateFin',                            DateType::class, array(
                'widget'    =>  'choice',
                'format'    =>  'dd/MM/yyyy',
                'years' =>  array(
                    $currentDate->format('Y'),
                    $currentDate->format('Y')+1
                ),
            ))
            ->add('prixVente',                          NumberType::class)
            ->add('commercial',                         TextType::class, array(
                'data'  =>  $commercial->getPrenom(),
                'disabled'  =>  true
            ))
            ->add('montantCommission',                  NumberType::class, array(
                'disabled'  =>  true,
            ))
            ->add('commissionSupplementaire',           NumberType::class)
            ->add('montantCommissionSuplementaire',     NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('equipe',                             EntityType::class, array(
                'class' =>  Equipe::class,
                'choice_label'  =>  'nom'
            ))
            ->add('jourPrevuCharpente',                 NumberType::class)
            ->add('montantPrevuCharpente',              NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('jourReelCharpente',                  NumberType::class)
            ->add('montantReelCharpente',               NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('jourPrevuFinitions',                 NumberType::class)
            ->add('montantPrevuFinitions',              NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('jourReelFinitions',                  NumberType::class)
            ->add('montantReelFinitions',               NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('forfaitPrevuCharpente',              NumberType::class)
            ->add('montantForfaitPrevuCharpente',       NumberType::class, array(
                'disabled'  =>  true,
            ))
            ->add('forfaitReelCharpente',               NumberType::class)
            ->add('montantForfaitReelCharpente',        NumberType::class, array(
                'disabled'  =>  true,
            ))
            ->add('boisVeluxPrevu',                     NumberType::class)
            ->add('boisVeluxReel',                      NumberType::class)
            ->add('forfaitPrevuIsolation',              NumberType::class)
            ->add('montantForfaitPrevuIsolation',       NumberType::class, array(
                'disabled'  =>  true,
            ))
            ->add('forfaitReelIsolation',               NumberType::class)
            ->add('montantForfaitReelIsolation',        NumberType::class, array(
                'disabled'  =>  true,
            ))
            ->add('escalier',                           NumberType::class)
            ->add('escalierReel',                       NumberType::class)
            ->add('electricitePrevu',                   NumberType::class)
            ->add('electriciteReel',                    NumberType::class)
            ->add('isolationPrevu',                     NumberType::class)
            ->add('isolationReel',                      NumberType::class)
            ->add('veluxEtAccesPrevu',                  NumberType::class)
            ->add('veluxEtAccesReel',                   NumberType::class)
            ->add('plancherPrevu',                      NumberType::class)
            ->add('plancherReel',                       NumberType::class)
            ->add('placardPrevu',                       NumberType::class)
            ->add('placardReel',                        NumberType::class)
            ->add('plomberiePrevu',                     NumberType::class)
            ->add('plomberieReel',                      NumberType::class)
            ->add('parquetPrevu',                       NumberType::class)
            ->add('parquetReel',                        NumberType::class)
            ->add('peinturePrevu',                      NumberType::class)
            ->add('peintureReel',                       NumberType::class)
            ->add('portePrevu',                         NumberType::class)
            ->add('porteReel',                          NumberType::class)
            ->add('bennePrevu',                         NumberType::class)
            ->add('benneReel',                          NumberType::class)
            ->add('totalCoutsPrevu',                    NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('totalCoutsReel',                     NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('margeEnValeurPrevu',                 NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('margeEnValeurReel',                  NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('pourcentageMargePrevu',              NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('pourcentageMargeReel',               NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('margeJourPrevu',                     NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('margeJourReel',                      NumberType::class, array(
                'disabled'  =>  true
            ))
            ->add('champSupps',                         CollectionType::class, array(
                'entry_type'    =>  ChampSuppType::class,
                'allow_add' =>  true,
                'allow_delete'  =>  true
            ))
            ->add('save',                               SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HEI\MargeBundle\Entity\Chantier'
        ));
        $resolver->setRequired(['contact']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hei_margebundle_chantier';
    }


}
