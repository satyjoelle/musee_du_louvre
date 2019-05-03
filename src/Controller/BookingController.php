<?php
/**
 * Created by PhpStorm.
 * User: faveu
 * Date: 13/03/2019
 * Time: 01:10
 */

namespace App\Controller;
use App\Entity\Booking;
use App\Entity\Visitor;
use App\Form\BookingFormType;
use App\Form\VisitorFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;



class BookingController extends AbstractController
{
    /**
     * @Route("/add", name="book")
     */
    public function addAction(Request $request)

    {
        $booking = new Booking();

        $form = $this->createForm(BookingFormType::class, $booking);

        //dump($request->request->get("quantite")); //handlerequest recupere les champs entrés par le visiteur
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $booking = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($booking);
             $entityManager->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Commande bien enregsitrée.'); //get session sauvegarde l'objet booking
            $request->getSession()->set("booking", $booking);
            //dump($request->getSession()->get("booking"));
            return $this->redirectToRoute('visit');


        }

        return $this->render('booking/add.html.twig', [
            'bookingForm' =>$form->createView()
        ]);


    }

    /**
     * @Route("/visit", name="visit")
     */
    public function addInformationAction(Request $request)
    {
        $quantite = $request->getSession()->get("booking")->getQuantite();

        for ($i = 1; $i <= $quantite; $i++) {

            $visitor[] = new Visitor();

        }


        $form = $this->createForm(CollectionType::class, $visitor, ["entry_type" => VisitorFormType::class]);

       // dd($form->getgetData());die;
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // dd($form->getData()[0]->getDateDeNaissance()->format('Y'));

            //dd($form->getData());
            $age =2019 - (int)$form->getData()[0]->getDateDeNaissance()->format('Y'); //recupere tous les données recupérer par le formulaire, le 1er formulaire
            $price = 0;


            if($form->getData()[0]->getTarifReduit() == true){ //get data recuperer les donnees du formulaire
                $price = 10;
                dd($price);

            }else{
                if($age >= 12){
                    $price=16;
                    dd($price);
                }elseif ($age >= 4 && $age < 12){
                    $price=8;
                    dd($price);
                }elseif ($age >= 60){
                    $price=12;
                    dd($price);
                }
            }

        }

            return $this->render('booking/visitor.html.twig', array('form' => $form->createView()));

    }



}