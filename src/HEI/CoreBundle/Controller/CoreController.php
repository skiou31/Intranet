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

    public function changeAction()
    {
    }
}