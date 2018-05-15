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

        $rdv = "12/12/2018 14:15";
        $rdvArray = explode(" ", $rdv);

        $response = $mailSarbacane->addToReceptionList("Monsieur", "Sébastien", "Hallez", "hallez.harnois@orange.fr", "0600000000");

        return $this->render('HEICoreBundle:Core:test.html.twig', array(
           'response'   =>  $response
        ));
    }
}