<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 13/02/2018
 * Time: 10:15
 */

namespace HEI\ContactBundle\Controller;

use HEI\ContactBundle\Entity\Comment;
use HEI\ContactBundle\Entity\Contact;
use HEI\ContactBundle\Form\ContactType;
use HEI\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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

                $mailSarbacane = $this->container->get('hei.mail_sarbacane');
                $mailSarbacane->addToWelcomeRdvList(
                    $contact->getCivilite(),
                    $contact->getPrenom(),
                    $contact->getNom(),
                    $contact->getEmail(),
                    $contact->getTelephone(),
                    $contact->getRendezVous()->format("Y-m-d H:i:s")
                );

                $mailInterne =$this->container->get('hei.mail_interne');
                $mailInterne->mailAddContact();

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
            ->add('commercial',         EntityType::class, array(
                'class'  => User::class,
                'choice_label'  =>  'nom'
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

    /**
     * @param Request $request
     * @return Response
     */
    public function consultAction(Request $request) {
        $repositoryContact     = $this->getDoctrine()->getManager()->getRepository('HEIContactBundle:Contact');
        $repositoryCommentaire = $this->getDoctrine()->getManager()->getRepository('HEIContactBundle:Comment');
        $id                    = $request->query->get('id');

        $contact      = $repositoryContact->getContactWithFiles($id);
        $commentaires = $repositoryCommentaire->findBy(
            array('contact'   =>  $id)
        );


        return $this->render('HEIContactBundle:Contact:consult.html.twig', array(
            'contact'       => $contact,
            'commentaires'  =>  $commentaires
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modifyAction(Request $request)
    {
        $mailSarbacane = $this->container->get('hei.mail_sarbacane');

        $currentDate = new \DateTime();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('HEIContactBundle:Contact')
        ;

        $contact = $repository->find($request->query->get('id'));

        $builder = $this->get('form.factory')->createBuilder(FormType::class, $contact);

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
            ->addEventListener(         FormEvents::PRE_SUBMIT, $listener)
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
                'required'  =>  false
            ))
            ->add('PS',                 TextareaType::class, array(
                'required'  =>  false,
            ))
        ;

        if ($this->get('security.authorization_checker')->isGranted('ROLE_DIRECTION')) {
            $builder->add('typeContact',        ChoiceType::class, array(
                'choices'   =>  array(
                    'Prospect'      =>  0,
                    'Client'        =>  1,
                    'Réceptionné'   =>  2,
                    'Annulé'        =>  3
                ),
                'placeholder'   =>  'Choisir'
            ));
        }

        $builder
            ->add('Enregistrer',        SubmitType::class)
        ;

        $form = $builder->getForm();

        $form->setData($contact);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($contact->getTypeContact() === 1) {
                $contact->setStatut(2);

                $mailSarbacane->addToSignatureList(
                    $contact->getCivilite(),
                    $contact->getPrenom(),
                    $contact->getNom(),
                    $contact->getEmail(),
                    $contact->getTelephone(),
                    $contact->getRendezVous()->format("Y-m-d H:i:s")
                );
            }
            elseif ($contact->getTypeContact() === 2) {
                $contact->setStatut(6);

                $mailSarbacane->addToReceptionList(
                    $contact->getCivilite(),
                    $contact->getPrenom(),
                    $contact->getNom(),
                    $contact->getEmail(),
                    $contact->getTelephone(),
                    $contact->getRendezVous()->format("Y-m-d H:i:s")
                );
            }

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();

                $mailInterne =$this->container->get('hei.mail_interne');
                $mailInterne->mailAddContact();

                return $this->redirectToRoute('hei_contact_consult', array(
                    'id' => $contact->getId(),
                ));
            }
        }

        return $this->render('HEIContactBundle:Contact:modify.html.twig', array(
            'form'  => $form->createView(),
        ));
    }

    public function addCommentAction(Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('HEIContactBundle:Contact')
        ;
        $id = $request->query->get("id");
        $contact = $repository->findOneBy(array('id' => $id));
        $contactArray = array($contact);

        $comment = new Comment();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $comment);

        $formBuilder
            ->add('comment',    TextareaType::class)
            ->add('contact',    EntityType::class, array(
                'class'         => Contact::class,
                'choice_label'  => 'nom',
                'choices'       => $contactArray,
            ))
            ->add('Ajouter',     SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                return $this->redirectToRoute('hei_contact_consult', array(
                    'id' => $id,
                ));
            }
        }

        return $this->render('HEIContactBundle:Contact:addComment.html.twig', array(
            'form'  => $form->createView(),
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