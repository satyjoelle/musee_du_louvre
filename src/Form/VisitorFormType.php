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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



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
            ->add('dateDeNaissance')
            ->add('tarifReduit')
            ->add('booking');
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