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
     * @throws Error
     */
    public function mailAddContact()
    {
        $message = (new \Swift_Message('Un nouveau contact pour vous'))
            ->setFrom('multispaces-harnois@orange.fr')
            ->setTo('v.fuger-harnois@orange.fr')
            ->setBody(
                $this->templating->render(
                    'Emails/addContact.html.twig'
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    /**
     * @throws Error
     */
    public function mailModifContact()
    {
        $message = (new \Swift_Message('Un de vos contact a été modifié'))
            ->setFrom('multispaces-harnois@orange.fr')
            ->setTo('v.fuger@orange.fr')
            ->setBody(
                $this->templating->render(
                    'Emails/modifContact.html.twig'
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}