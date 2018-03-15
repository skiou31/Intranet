<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 13/03/2018
 * Time: 10:36
 */

namespace HEI\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom');
        $builder->add('prenom');
        $builder->add('telephone');
        $builder->add('roles', CollectionType::class, array(
            'entry_type'    =>  ChoiceType::class,
            'entry_options' =>  array(
                'label'         =>  false,
                'choices'       =>  array(
                    'ROLE_COMMERCIAL'   =>  'ROLE_COMMERCIAL',
                    'ROLE_CONDUC'       =>  'ROLE_CONDUC',
                    'ROLE_DIRECTION'    =>  'ROLE_DIRECTION',
                )
            )
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}