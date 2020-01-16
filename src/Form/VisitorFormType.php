<?php
/**
 * Created by PhpStorm.
 * User: faveu
 * Date: 13/03/2019
 * Time: 01:39
 */

namespace App\Form;

use App\Entity\Visitor;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class VisitorFormType extends  AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /**
         * {@inheritdoc}
         */
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('pays')
            ->add('dateDeNaissance', BirthdayType::class,[
                'placeholder' => ['day'=>'Jour','month'=>'Mois','year'=>'Année'],
                'format'=>'dd MM yyy'
            ])
            ->add('tarifReduit', CheckboxType::class, [    'required'   => false,
            'label' => 'Tarif réduit de 10 euros 
            - Tarif accordé sous certaines conditions (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire…)',
            ]);
            //->add('booking');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Visitor::class,
        ));
    }




}