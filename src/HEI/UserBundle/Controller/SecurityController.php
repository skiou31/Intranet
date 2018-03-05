<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 01/03/2018
 * Time: 12:02
 */

namespace HEI\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request){
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('hei_core_homepage');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('HEIUserBundle:Security:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }
}