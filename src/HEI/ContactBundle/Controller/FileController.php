<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 09/03/2018
 * Time: 13:51
 */

namespace HEI\ContactBundle\Controller;


use HEI\ContactBundle\Entity\Contact;
use HEI\ContactBundle\Entity\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
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
            ->add('contact',    EntityType::class, array(
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

    public function downloadAction(Request $request)
    {
        $contactId = $request->query->get('id');
        $filename  = $request->query->get('filename');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('HEIContactBundle:Contact')
        ;

        $contact = $repository->getContactWithFiles($contactId);
        $files = $contact[0]->getFiles();


        foreach ($files as $key => $value) {
            if ($value->getNom() === $filename) {
                $response = new Response();
                $response->setStatusCode(200);
                $response->headers->set('Content-Type', 'image/jpg');
                $response->headers->set('Content-Disposition', sprintf('attachement;filename="%s"', $value->getNom()));
                $response->setCharset('UTF-8');
                $response->setContent(file_get_contents( $value->getUploadDir()."/".$value->getNom() ));

                $response->send();
                return $response;
            }
        }
    }

    public function removeAction(Request $request)
    {
        $contactId = $request->query->get('id');
        $filename  = $request->query->get('filename');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('HEIContactBundle:Contact')
        ;

        $contact = $repository->getContactWithFiles($contactId);
        $files = $contact[0]->getFiles();

        foreach ($files as $key => $value) {
            if ($value->getNom() === $filename) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($value);
                $em->flush();
            }
        }

        return $this->render('HEIContactBundle:Contact:consult.html.twig', array(
            'contact'    =>  $repository->getContactWithFiles($contactId),
            'files'      =>  $files
        ));
    }
}