<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
// ========= ADD SERVICE
use App\Service\MailService;
// ========= ADD REQUETE
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;




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

//==========================Set data pour sendMessage() ==============================
            $dataContact = $formulaireContact->getData(); //dataContact array with "name", "service", "mail", "objet", "message"
            //dump($dataContact);
            $dataService = $formulaireContact['service']->getData(); //dataService array with "nameService", "mailRef", "mailSecondary"

//==========================Envoie dans la base de donnée (persistance + flush -> contactData)===============================
            $manager->persist($dataContact);
            $manager->flush();

//==========================Envoie mail ==============================
            $message = MailService::sendMessage($dataContact,$dataService);
            $mailer->send($message);
            //dump($message);

//==========================CONFIRMATION MSG ==========================
            MailService::infoSend(); // -->Appel de la fonction infoSend() de la classe MailService
//=========================================================================
           #return $this->redirectToRoute('contact'); //enlever # si .envi est config' 
        } 
       

        return $this->render('contact/contact.html.twig', [
            'formulaireContact' => $formulaireContact->createView(),
            'title' => 'Nous contacter',
        ]);

    }
}
