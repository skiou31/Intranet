<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 12/03/2018
 * Time: 14:35
 */

namespace HEI\GestionBundle\Controller;


use HEI\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GestionController extends Controller
{
    public function usersAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('HEIUserBundle:User');

        $users = $em->findAll();

        return $this->render('HEIGestionBundle:Gestion:index.html.twig', array(
            'users' => $users,
        ));
    }

    public function addUser()
    {
        $user = new User();
    }
}