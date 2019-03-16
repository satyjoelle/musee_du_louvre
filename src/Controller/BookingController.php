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

            $request->getSession()->getFlashBag()->add('notice', 'Commande bien enregsitrée.'); //get session sauvegarde l'objet booking
            $request->getSession()->set("booking", $booking);
            dump($request->getSession()->get("booking"));
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

        return $this->render('booking/visitor.html.twig', array('form' => $form->createView()));

    }



}