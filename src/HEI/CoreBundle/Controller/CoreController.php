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
        $mailInterne = $this->container->get('hei.mail_interne');

        $mailInterne->mailAddContact("v.fuger-harnois@orange.fr", "Fuger", "Vincent", "76 rue du général de Gaulle 59370 Mons", "0671303941", "skiou31@gmail.com", "25/05/2018 15:00", "LOOOOOOOOOOOL");

        return $this->render('HEICoreBundle:Core:test.html.twig');
    }
}