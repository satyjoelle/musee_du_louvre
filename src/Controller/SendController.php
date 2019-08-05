<?php

namespace App\Controller;

use App\Entity\Booking;
//use App\Form\BookingFormType;
//use App\Form\VisitorFormType;

//use App\Entity\Visitor;
use App\Form\VisitorFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class SendController extends AbstractController

{

    /**
     * @Route("/send", name="sendpdf")
     */
    public function index()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('default/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
        //recuperer les informations à afficher dans le pdf

   function recup (Request $request)
    {
        $booking = new Booking();

        $form = $this->createForm(CollectionType::class, $booking,["entry_type" =>VisitorFormType::class]);
        $donnees = array(array());

        $quantite = $request->getSession()->get( "booking")->getQuantite();
       for ($i=0; $i< $quantite; $i++) {
           $donnees = jourdevisite();
           $donnees [$i] ['jourdevisite'] = $form->getData()[$i]->getJourDeVisite();
           dd($donnees);


       }

        return $this->render('booking/defaultcheckout.html.twig', ['donnees'=>$donnees]);

    }




}