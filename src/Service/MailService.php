<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Session\Session;

class MailService
{
    public function sendMessage($dataContact,$dataService)
    {
        
        $message = (new \Swift_Message())
        ->setSubject("Message de : ".$dataContact->getNom()." à pour objet [ ".$dataContact->getObjet()." ]")
        ->setFrom($dataContact->getMail())
        ->setTo([$dataService->getMailRef(),$dataService->getMailSecondary()])
        ->setBody($dataContact->getMessage(),'text/html');

        return $message;
    }
     public function infoSend()
    {
        $session = new Session();
        $session->getFlashBag()->add('success', 'Votre mail à bien été envoyer');
    }
}