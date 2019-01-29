<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// ========= ADD pour requete 
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\ServicesData;
use App\Entity\ContactData;
use Symfony\Component\HttpFoundation\Session\Session;

//ADD TYPE CONTACT
use Symfony\Bridge\Doctrine\Form\Type\EntityType;






class ContactController extends AbstractController
{
    /**
     * @Route("/contactme", name="contact")
     */
    public function index(Request $request,ObjectManager $manager,\Swift_Mailer $mailer){
        //dump($request);
        $contactData = new ContactData();

//========================les champs pour le form ==============================
        $formulaireContact = $this->createFormBuilder($contactData)
                                ->add('nom')
                                ->add('service', EntityType::class, [ //check data -> table ServicesData
                                    'class' => ServicesData::class,
                                    'choice_label' => 'name_service'
                                ])
                                ->add('mail')
                                ->add('objet')
                                ->add('message')
                                ->getForm();

        $formulaireContact->handleRequest($request);
        // $formulaireContact->getData() == $contactData
        if($formulaireContact->isSubmitted() && $formulaireContact->isValid() ){ //le form est Submit ? et ok?
            
            $dataContact = $formulaireContact->getData(); //dataContact array with "name", "service", "mail", "objet", "message"
            $dataService = $formulaireContact['service']->getData(); //dataService array with "nameService", "mailRef", "mailSecondary"
            dump($dataContact->getMail());
            //dump($dataService);

//==============================Création du mail avec récup des data contact et service ===========

            $message = (new \Swift_Message())
                ->setSubject("Message de : ".$dataContact->getNom()." à pour objet [ ".$dataContact->getObjet()." ]")
                ->setFrom($dataContact->getMail())//$dataContact->getMail()
                ->setTo([$dataService->getMailRef(),$dataService->getMailSecondary()])
                ->setBody($dataContact->getMessage(),'text/html');
            
            $mailer->send($message);

//==========================Envoie dans la base de donnée (persistance + flush -> contactData)
            $manager->persist($contactData);
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
