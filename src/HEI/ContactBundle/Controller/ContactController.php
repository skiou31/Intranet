<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 13/02/2018
 * Time: 10:15
 */

namespace HEI\ContactBundle\Controller;

use Doctrine\ORM\EntityRepository;
use HEI\ContactBundle\Entity\Contact;
use HEI\ContactBundle\Entity\File;
use HEI\ContactBundle\Form\ContactType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vicopo\Vicopo;

/**
 * Class ContactController
 * @package HEI\ContactBundle\Controller
 */
class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request) {
        $contact = new Contact();
        $form = $this->get('form.factory')->create(ContactType::class, $contact);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();

                return $this->redirectToRoute('hei_contact_consult', array(
                    'id' => $contact->getId(),
                ));
            }
        }

        return $this->render('HEIContactBundle:Contact:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function searchAction(Request $request) {
        $contact = new Contact();

        $listener = function (FormEvent $event) {
            $data = $event->getData();

            if (!$data) {
                return;
            }

            $ville = $data["ville"];

            $event
                ->getForm()
                ->add('ville',      ChoiceType::class, array(
                    'required'  => false,
                    'choices'   =>  array(
                        $ville  =>  $ville
                    )
                ))
            ;
        };

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $contact);

        $formBuilder
            ->add('nom',            TextType::class, array(
                'required'  =>  false
            ))
            ->add('codePostal',     NumberType::class, array(
                'required'  =>  false
            ))
            ->add('ville',          ChoiceType::class, array(
                'required'  =>  false
            ))
            ->addEventListener(     FormEvents::PRE_SUBMIT, $listener)
            ->add('adresse',        TextType::class, array(
                'required'  =>  false
            ))
            ->add('Rechercher',     SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('HEIContactBundle:Contact')
                ;

                $contacts = $repository->findContacts($contact);

                return $this->render('HEIContactBundle:Contact:search.html.twig', array(
                    'form'  => $form->createView(),
                    'contacts' => $contacts,
                ));
            }
        }

        return $this->render('HEIContactBundle:Contact:search.html.twig', array(
            'form'  => $form->createView(),
        ));
    }

    public function consultAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('HEIContactBundle:Contact');

//        $contact = $repository->find($request->query->get('id'));
        $contact = $repository->getContactWithFiles($request->query->get('id'));

//        $files = $contact->getFiles();

        return $this->render('HEIContactBundle:Contact:consult.html.twig', array(
            'contact' => $contact,
//            'files'   => $files
        ));
    }

    public function addFileAction(Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('HEIContactBundle:Contact')
        ;
        $type = $request->query->get("type");
        $id = $request->query->get("id");
        $contact = $repository->findOneBy(array('id' => $id));
        $contactArray = array($contact);

        $file = new File();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $file);

        $formBuilder
            ->add('file',       FileType::class)
            ->add('type',       ChoiceType::class, array(
                'choices'   =>  array(
                    'Photo'         =>  'Photo',
                    'Devis'         =>  'Devis',
                    'Plan'          =>  'Plan',
                    'Administratif' =>  'Administratif',
                    'Chèque'        =>  'Chèque'
                )
            ))
            ->add('contact',     EntityType::class, array(
                'class'         => Contact::class,
                'choice_label'  =>  'nom',
                'choices'       => $contactArray
            ))
            ->add('Envoyer',    SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $file->upload($type, $id);

                $em = $this->getDoctrine()->getManager();
                $em->persist($file);
                $em->flush();

                return $this->redirectToRoute('hei_contact_consult', array(
                    'id' => $id,
                ));
            }
        }

        return $this->render('HEIContactBundle:File:add.html.twig', array(
            'form'  => $form->createView(),
            'contact'   => $contact
        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function autocompleteAction(Request $request) {
        $codePostal = $request->query->get('codePostal');

        $data = Vicopo::http($codePostal);
        $dataJSON = json_encode($data);

        return new JsonResponse($dataJSON);
    }
}