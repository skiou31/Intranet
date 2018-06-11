<?php

namespace HEI\MargeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChantierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeChantier')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('prixVente')
            ->add('montantCommission')
            ->add('commissionSupplementaire')
            ->add('montantCommissionSuplementaire')
            ->add('equipe')
            ->add('jourPrevuCharpente')
            ->add('montantPrevuCharpente')
            ->add('jourReelCharpente')
            ->add('montantReelCharpente')
            ->add('jourPrevuFinitions')
            ->add('montantPrevuFinitions')
            ->add('jourReelFinitions')
            ->add('montantReelFinitions')
            ->add('forfaitPrevuCharpente')
            ->add('montantForfaitPrevuCharpente')
            ->add('forfaitReelCharpente')
            ->add('montantForfaitReelCharpente')
            ->add('boisVeluxPrevu')
            ->add('boisVeluxReel')
            ->add('forfaitPrevuIsolation')
            ->add('montantForfaitPrevuIsolation')
            ->add('forfaitReelIsolation')
            ->add('montantForfaitReelIsolation')
            ->add('escalier')
            ->add('escalierReel')
            ->add('electricitePrevu')
            ->add('electriciteReel')
            ->add('isolationPrevu')
            ->add('isolationReel')
            ->add('veluxEtAccesPrevu')
            ->add('veluxEtAccesReel')
            ->add('plancherPrevu')
            ->add('plancherReel')
            ->add('placardPrevu')
            ->add('placardReel')
            ->add('plomberiePrevu')
            ->add('plomberieReel')
            ->add('parquetPrevu')
            ->add('parquetReel')
            ->add('peinturePrevu')
            ->add('peintureReel')
            ->add('portePrevu')
            ->add('porteReel')
            ->add('totalCoutsPrevu')
            ->add('totalCoutsReel')
            ->add('margeEnValeurPrevu')
            ->add('margeEnValeurReel')
            ->add('pourcentageMargePrevu')
            ->add('pourcentageMargeReel')
            ->add('margeJourPrevu')
            ->add('margeJourReel')
            ->add('contact')
            ->add('commercial');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HEI\MargeBundle\Entity\Chantier'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hei_margebundle_chantier';
    }


}
