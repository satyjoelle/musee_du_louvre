<?php


namespace App\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Services;
use App\Entity\Services\HourBillet;
use App\Entity\Booking;
use App\Entity\Visitor;
use App\Form\BookingFormType;
use App\Form\VisitorFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;


class BookingController extends AbstractController
{

    /**
     * @Route("/add", name="book")
     */
    public function addAction(Request $request)
    {
            
        $booking = new Booking();

        $form = $this->createForm(BookingFormType::class, $booking);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
           
            $entityManager = $this->getDoctrine()->getManager();
           
            //rajouter le service 
            $request = $this->requestStack->getCurrentRequest();
            $booking = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $result = $entityManager->getRepository(Booking::class)->sumQuantity($booking->getJourDeVisite());

            $entityManager->persist($booking);


            //récupération du jour de visite 
            $day = $jour_visite->getDay();

            //test si un billet est acheté le même jour au dessus de 14h
            foreach ($type_de_billet as $nbillet => $type_de_billet)

            //recuperation du type de billet
            $type_de_billet = $reservation->getTypeDeBillet();
            
            $hourBillet = $this->RevervHourBillet->hourBillet($type_de_billet, $jour_de_visite);

           if($hourBillet == 'notHourBillet')

                {
                  
                    $session->getFlashBag()->add('hourBillet', 'Votre billet '.($nbillet+1).' n\'est pas valide. 
                    Vous ne pouvez commandé de billet "journée" au-dessus de 14 heures.');

                    
                return;
                }

            
            
            if($result <= 1000){
               
                $entityManager->persist($booking);
                
                $entityManager->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Commande bien enregsitrée.'); 
                $request->getSession()->set("booking", $booking);

                return $this->redirectToRoute('visit'); 

            }else{
                $this->addFlash('d', 'Nombre de reservations atteint, veuillez réserver un autre jour !');
            }

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


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


             $total = 0;

            
            $donnees = array(array());
             for ($i = 0; $i < $quantite; $i++) {
                 
                if($form->getData()[$i]->getTarifReduit() == true){ 
                    $price = 10;
                    $donnees[$i]['prix'] = $price;
                    $donnees[$i]['nom'] = $form->getData()[$i]->getNom();
                    $donnees[$i]['prenom'] = $form->getData()[$i]->getPrenom();
                    $donnees[$i]['code'] = MD5($donnees[$i]['nom'].$donnees[$i]['prenom']);

                    $total += $price;
                    $request->getSession()->set("total", $total);

                }else{ 
                    $year  = date("Y") - (int)$form->getData()[$i]->getDateDeNaissance()->format('Y');
                    
                    $donnees[$i]['prix'] = $this->recup($year);
                    $donnees[$i]['nom'] = $form->getData()[$i]->getNom();
                    $donnees[$i]['prenom'] = $form->getData()[$i]->getPrenom();
                    $donnees[$i]['code'] = MD5($donnees[$i]['nom'].$donnees[$i]['prenom']);


                    $total += $this->recup($year); 

                    $request->getSession()->set("total", $total);
                }


            }

          
            $request->getSession()->set("don", $donnees);
            $_SESSION['donnees'] = $donnees;
            return $this->render('booking/order/checkout.html.twig', ['donnees'=>$donnees, 'total'=>$total]);
        }

            return $this->render('booking/visitor.html.twig', array('form' => $form->createView()));
    }

    public function recup($age){
        if($age >= 0 && $age <= 4){
            $price = 0 ;
            return $price;
        }elseif($age > 4 && $age <= 12){
            $price = 8 ;
            return $price;
        }elseif($age > 12 && $age < 60){
            $price = 16;
            return $price;
        }elseif($age >= 60){
            $price = 12;
            return $price;
        }
    }

    /**
     *
     * @Route("/checkout", name="order_checkout")
     */
    public function checkoutAction(Request $request)
    {

        if ($request->isMethod('POST')){

            $token = $request->get('stripeToken');
            

            \Stripe\Stripe::setApiKey('sk_test_KtGoClctxPWcK6RVvqfiCaG000PsHa5oQ8');

            $charge = \Stripe\Charge::create([
                'amount' => $request->getSession()->get("total")*100,
                'currency' => 'eur',
                'source' => $token,
                'receipt_email' => 'faveurextra@gmail.com',
            ]);
            
            $this->addFlash('success', 'Order Complete! Yay!');

            return $this->redirectToRoute('envoi');
        }




    }

    /**
     * @Route("/envoi", name="envoi")
     */
    public function sendEmail( Request $request, $name='',\Swift_Mailer $mailer)
    {

        
        $jour_visite = $request->getSession()->get('booking')->getJourDeVisite();
       $emailTo = $request->getSession()->get("booking")->getEmail();

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('faveurextra@gmail.com')
            ->setTo($emailTo)
            ->setBody(
                $this->renderView(
                
                    'emails/registration.html.twig',
                    ['jour_visite'=>$jour_visite, 'name' => $name, 'donnees'=>$_SESSION['donnees']]
                ),
                'text/html'
            );

        $mailer->send($message);



        return $this->render('emails/envoi.html.twig', []);
    }
}



