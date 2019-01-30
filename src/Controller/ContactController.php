<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// ========= ADD REQUETE
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Session\Session;


class ContactController extends AbstractController
{
    /**
     * @Route("/contactme", name="contact")
     */
    public function index(Request $request,ObjectManager $manager,\Swift_Mailer $mailer){
        //dump($request);


        $formulaireContact = $this->createForm(ContactFormType::class);
        $formulaireContact->handleRequest($request);

        if($formulaireContact->isSubmitted() && $formulaireContact->isValid() ){ //le form est Submit ? et ok?
            $dataContact = $formulaireContact->getData(); //dataContact array with "name", "service", "mail", "objet", "message"
            //dump($dataContact);
            $dataService = $formulaireContact['service']->getData(); //dataService array with "nameService", "mailRef", "mailSecondary"
            //dump($dataContact->getMail());
            //dump($dataService);

//==============================Création du mail avec récup des data contact et service ===========

            $message = (new \Swift_Message())
                ->setSubject("Message de : ".$dataContact->getNom()." à pour objet [ ".$dataContact->getObjet()." ]")
                ->setFrom($dataContact->getMail())
                ->setTo([$dataService->getMailRef(),$dataService->getMailSecondary()])
                ->setBody($dataContact->getMessage(),'text/html');
            
            $mailer->send($message);

//==========================Envoie dans la base de donnée (persistance + flush -> contactData)
            $manager->persist($dataContact);
            $manager->flush();
            
//==========================CONFIRMATION MSG ==========================
            $session = new Session();
            
            $this->addFlash(
                'success',
                'Votre mail à bien été envoyer'
            );
//=========================================================================
           #return $this->redirectToRoute('contact'); //enlever # si .envi est config' 
        } 
       

        return $this->render('contact/contact.html.twig', [
            'formulaireContact' => $formulaireContact->createView(),
            'title' => 'Nous contacter',
        ]);

    }
}
