<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//ADD pour requete 
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\ServicesData;

use App\Entity\ContactData;
use App\Repository\ContactDataRepository;

use Symfony\Component\HttpFoundation\Session\Session;

//ADD TYPE CONTACT
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;





class ContactController extends AbstractController
{
    /**
     * @Route("/contactme", name="contact")
     */
    public function index(Request $request,ObjectManager $manager,\Swift_Mailer $mailer){
        //dump($request);
        $contactData = new ContactData();

//========================les champs pour le formulaire ==============================
        $formulaireContact = $this->createFormBuilder($contactData)
                                ->add('nom')
                                ->add('service', EntityType::class, [ //check data dans la table ServicesData
                                    'class' => ServicesData::class,
                                    'choice_label' => 'name_service'
                                ])
                                ->add('mail')
                                ->add('objet')
                                ->add('message')
                                ->getForm();

        $formulaireContact->handleRequest($request);
        // $formulaireContact->getData() == $contactData
        if($formulaireContact->isSubmitted() && $formulaireContact->isValid() ){ //le form est complété ? et ok?
            
            $dataContact = $formulaireContact->getData(); //dataContact array with "name", "service", "mail", "objet", "message"
            $dataService = $formulaireContact['service']->getData(); //dataService array with "nameService", "mailRef", "mailSecondary"
            dump($dataContact->getNom());
            //dump($dataService);

//==============================Création du mail avec récup des data contact et service ===========

            $message = (new \Swift_Message())
                ->setSubject($dataContact->getObjet())
                ->setFrom($dataContact->getMail())//$dataContact->getMail()
                ->setTo([$dataService->getMailRef(),$dataService->getMailSecondary()])
                ->setBody($dataContact->getMessage(),'text/html');
            
            $mailer->send($message);

//==========================Envoie dans la base de donnée (persistance + flush dans data de contactData)
            $manager->persist($contactData);
            $manager->flush();
            
//==========================CONFIRMATION MSG ==========================
            $session = new Session();
            
            $this->addFlash(
                'success',
                'Votre mail à bien été envoyer'
            );
//=========================================================================
            //return $this->redirectToRoute('contact'); 
        }
       

        return $this->render('contact/contact.html.twig', [
            'formulaireContact' => $formulaireContact->createView(),
            'title' => 'Nous contacter',
        ]);

    }
}
