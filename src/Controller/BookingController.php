<?php


namespace App\Controller;
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

        //handlerequest lis,  recupere hydrate les champs du formulaire
        //avec le if on soumet le formulaire
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $booking = $form->getData();

            //dd($booking->getEMail());
            //$this->emailTo = $booking->getEmail();
            //ecrire le tableau
            // ...entitymanager fait le lien entre les entités et la bdd
             $entityManager = $this->getDoctrine()->getManager();
             //preparer la requete avant l'enregistrement, ajoute l'objet manipulé dans l'Unit of Work
             $entityManager->persist($booking);
             //execute la requete
             $entityManager->flush();

             //get session sauvegarde l'objet booking
            $request->getSession()->getFlashBag()->add('notice', 'Commande bien enregsitrée.'); 
            $request->getSession()->set("booking", $booking);

            return $this->redirectToRoute('visit'); //appelle la route en bas


        }

        return $this->render('booking/add.html.twig', [
            'bookingForm' =>$form->createView() //affichage du formulaire avant la soumission sans le if
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

            // Fonction de récupération du prix en fonction de la date de naissance
             $total = 0;

            // set and get session attributes
            $donnees = array(array());
             for ($i = 0; $i < $quantite; $i++) {
                 //recuperer le prix en fonction du tarif reduit
                if($form->getData()[$i]->getTarifReduit() == true){ //get data recupere les donnees du formulaire
                    $price = 10;
                    $donnees[$i]['prix'] = $price;
                    $donnees[$i]['nom'] = $form->getData()[$i]->getNom();
                    $donnees[$i]['prenom'] = $form->getData()[$i]->getPrenom();
                    $donnees[$i]['code'] = MD5($donnees[$i]['nom'].$donnees[$i]['prenom']);

                    $total += $price;
                    $request->getSession()->set("total", $total);

                }else{  //recuperer le prix en fonction de l age
                    $year  = date("Y") - (int)$form->getData()[$i]->getDateDeNaissance()->format('Y');
                    //dd($year);
                    $donnees[$i]['prix'] = $this->recup($year);
                    $donnees[$i]['nom'] = $form->getData()[$i]->getNom();
                    $donnees[$i]['prenom'] = $form->getData()[$i]->getPrenom();
                    $donnees[$i]['code'] = MD5($donnees[$i]['nom'].$donnees[$i]['prenom']);


                    $total += $this->recup($year); //retourne le prix qui fait age, function recup age en bas

                    //set("total")?signification

                    $request->getSession()->set("total", $total);
                }


            }

            //dump($donnees);
            $request->getSession()->set("don", $donnees);
            $_SESSION['donnees'] = $donnees;
            return $this->render('booking/order/checkout.html.twig', ['donnees'=>$donnees, 'total'=>$total]);
        }

            return $this->render('booking/visitor.html.twig', array('form' => $form->createView()));
    }

    function recup($age){
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
            //dump($request->getSession()->get("total"));

            \Stripe\Stripe::setApiKey('sk_test_KtGoClctxPWcK6RVvqfiCaG000PsHa5oQ8');

            $charge = \Stripe\Charge::create([
                'amount' => $request->getSession()->get("total")*100,
                'currency' => 'eur',
                'source' => $token,
                'receipt_email' => 'faveurextra@gmail.com',
            ]);
            //$request->getSession()->clear();
            $this->addFlash('success', 'Order Complete! Yay!');

            return $this->redirectToRoute('envoi');
        }




    }

    /**
     * @Route("/envoi", name="envoi")
     */
    public function sendEmail( Request $request, $name='',\Swift_Mailer $mailer)
    {

        //dd($_SESSION['donnees']);
        $jour_visite = $request->getSession()->get('booking')->getJourDeVisite();
       $emailTo = $request->getSession()->get("booking")->getEmail();

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('faveurextra@gmail.com')
            ->setTo($emailTo)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['jour_visite'=>$jour_visite, 'name' => $name, 'donnees'=>$_SESSION['donnees']]
                ),
                'text/html'
            );

        //getSession pour recuperer les valeurs d une variable hors des fonctions ou elles ont ete declarées

        $mailer->send($message);



        return $this->render('emails/envoi.html.twig', []);
    }
}



