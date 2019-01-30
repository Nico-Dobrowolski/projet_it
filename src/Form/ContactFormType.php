<?php

namespace App\Form;

//ADD ENTITY
use App\Entity\ContactData;
use App\Entity\ServicesData;

//ADD COMPONENT FORM
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//ADD TYPE data
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //========================les champs pour le form ==============================
            ->add('nom')
            ->add('service', EntityType::class, [ //check data -> table ServicesData
                'class' => ServicesData::class,
                'choice_label' => 'name_service'
            ])
            ->add('mail')
            ->add('objet')
            ->add('message')
        ;
        
        //!=========================================================================!
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactData::class,
        ]);
    }
}
