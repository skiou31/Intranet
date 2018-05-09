<?php

namespace HEI\MargeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HEIMargeBundle:Default:index.html.twig');
    }
}
