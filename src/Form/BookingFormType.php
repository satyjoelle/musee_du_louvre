<?php
/**
 * Created by PhpStorm.
 * User: faveu
 * Date: 13/03/2019
 * Time: 00:01
 */

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class BookingFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('jourDeVisite', DateType::class,[
              'widget' =>'single_text',
              ])

           ->add('typeDeBillet', ChoiceType::class, [
               'choices'  => ['billet journée' => true, 'billet demi journée' => true],
           ])

           ->add('quantite' )

           ->add('eMail');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        //resolver reconnait les chanmps du formulaire
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }





}