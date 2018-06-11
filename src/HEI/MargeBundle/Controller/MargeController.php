<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 11/06/2018
 * Time: 11:01
 */

namespace HEI\MargeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MargeController extends Controller
{
    public function indexAction()
    {
        return $this->render('HEIMargeBundle:Default:index.html.twig');
    }

    public function nouveauChantierAction()
    {
        return $this->render('HEIMargeBundle:Default:index.html.twig');
    }
}