<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 18/04/2018
 * Time: 15:36
 */

namespace HEI\ServicesBundle\MailInterne;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Twig\Error\Error;

class HEIMailInterne
{
    private $mailer;
    private $templating;

    /**
     * HEIMailInterne constructor.
     * @param TwigEngine $templating
     * @param \Swift_Mailer $mailer
     */
    public function __construct(TwigEngine $templating, \Swift_Mailer $mailer)
    {
        $this->templating = $templating;
        $this->mailer     = $mailer;
    }

    /**
     * @param $destinataire string
     * @param $nom string
     * @param $prenom string
     * @param $adresse string
     * @param $telephone string
     * @param $email string
     * @param $rendezVous string
     * @param $commentaire string
     * @throws Error
     */
    public function mailAddContact($destinataire, $nom, $prenom, $adresse, $telephone, $email, $rendezVous, $commentaire)
    {
        $message = (new \Swift_Message('Un nouveau contact pour vous'))
            ->setFrom('v.fuger-harnois@orange.fr')
            ->setTo($destinataire)
            ->setBody(
                $this->templating->render('Emails/addContact.html.twig', array(
                    "nom"           =>  $nom.' '.$prenom,
                    "adresse"       =>  $adresse,
                    "telephone"     =>  $telephone,
                    "mail"          =>  $email,
                    "rendezVous"    =>  $rendezVous,
                    "commentaire"   =>  $commentaire
                )),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    /**
     * @param $destinataire string
     * @param $nom string
     * @param $prenom string
     * @param $adresse string
     * @param $telephone string
     * @param $email string
     * @param $rendezVous string
     * @param $commentaire string
     * @throws Error
     */
    public function mailModifContact($destinataire, $nom, $prenom, $adresse, $telephone, $email, $rendezVous, $commentaire)
    {
        $message = (new \Swift_Message('Un de vos contact a été modifié'))
            ->setFrom('v.fuger-harnois@orange.fr')
            ->setTo($destinataire)
            ->setBody(
                $this->templating->render('Emails/addContact.html.twig', array(
                    "nom"           =>  $nom.' '.$prenom,
                    "adresse"       =>  $adresse,
                    "telephone"     =>  $telephone,
                    "mail"          =>  $email,
                    "rendezVous"    =>  $rendezVous,
                    "commentaire"   =>  $commentaire
                )),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}