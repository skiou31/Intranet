<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 11/06/2018
 * Time: 11:01
 */

namespace HEI\MargeBundle\Controller;

use HEI\MargeBundle\Entity\Chantier;
use HEI\MargeBundle\Form\ChantierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MargeController extends Controller
{
    public function indexAction()
    {
        return $this->render('HEIMargeBundle:Default:index.html.twig');
    }

    public function nouveauChantierAction(Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('HEIContactBundle:Contact')
        ;
        $id = $request->query->get("id");
        $contactReq = $repository->findOneBy(array('id' => $id));
        $contactArray = array($contactReq);
        $contact = $contactArray[0];

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('HEIMargeBundle:Valeur_defaut')
        ;
        $valeursDefaut = $repository->findAll();

        $chantier = new Chantier();
        $form = $this->get('form.factory')->create(ChantierType::class, $chantier, [
            'contact'   =>  $contact
        ]);

        return $this->render('HEIMargeBundle:Default:new.html.twig', array(
            'form'  =>  $form->createView(),
            'contact'   =>  $contactArray[0],
            'defauts'   =>  $valeursDefaut
        ));
    }
}