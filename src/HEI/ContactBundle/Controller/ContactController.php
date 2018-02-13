<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 13/02/2018
 * Time: 10:15
 */

namespace HEI\ContactBundle\Controller;

use HEI\ContactBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function addAction() {
        $contact = new Contact();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $contact);

        $formBuilder
            ->add('civilite',           CheckboxType::class)
            ->add('nom',                TextType::class)
            ->add('prenom',             TextType::class)
            ->add('adresse',            TextType::class)
            ->add('codePostal',         NumberType::class)
            ->add('ville',              ChoiceType::class)
            ->add('telephone',          NumberType::class)
            ->add('email',              TextType::class)
            ->add('origine',            ChoiceType::class)
            ->add('origineDetail',      ChoiceType::class)
            ->add('projet',             ChoiceType::class)
            ->add('typeMaison',         TextType::class)
            ->add('anneeConstruction',  NumberType::class)
            ->add('typeContact',        ChoiceType::class)
            ->add('commentaire',        TextareaType::class)
        ;

        $form = $formBuilder->getForm();

        return $this->render('HEIContactBundle:Contact:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}