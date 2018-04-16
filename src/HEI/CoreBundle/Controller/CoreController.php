<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 13/02/2018
 * Time: 11:27
 */

namespace HEI\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction() {
        return $this->render('HEICoreBundle:Core:index.html.twig');
    }

    public function testAction()
    {
        $mailSarbacane = $this->container->get('hei.mail_sarbacane');

        $response = $mailSarbacane->addToList("RZJlRHuVTYaCF82arSE27A", "Monsieur", "Sébastien", "Hallez", "hallez.harnois@orange.fr", "0600000000", "2018-08-01");

        return $this->render('HEICoreBundle:Core:test.html.twig', array(
           'response'   =>  $response
        ));
    }
}