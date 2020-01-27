<?php


namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;


class BookingFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
          ->add('jourDeVisite', DateType::class,[
                    'html5' => false,
                    'attr' => ['class' => 'datepicker'],
                    'widget' =>'single_text',
                   'format' => 'yyyy-MM-dd'
                

                ]
            )

           ->add('typeDeBillet', ChoiceType::class, [
               'choices'  => ['billet journée' => 0, 'billet demi journée (à partir de 14h)' => 1],
           ])

           /*
           ->add('date_created', DateType::class,[

           'data' => new \DateTime('now')

        ])*/
           ->add('quantite' , IntegerType::class, [
            'attr' => ['min'  => 1 , 'max' => '1000']])

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