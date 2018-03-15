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
use Symfony\Component\HttpFoundation\Request;

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

//    public function addUser()
//    {
//        $user = new User();
//    }

    public function deleteAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $id = $request->query->get('id');

        $user = $userManager->findUserBy(array('id' => $id));

        $userManager->deleteUser($user);

        return $this->redirectToRoute('hei_gestion_users');
    }
}