<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class EnvoiController extends AbstractController
{

    /**
     * @Route("/sendEmail", name="send_email")
     */
    public function sendEmail($name='',\Swift_Mailer $mailer)
    {
       

        $message = (new \Swift_Message('Musée du Louvre'))
            ->setFrom('faveurextra@gmail.com')
            ->setTo('eMail')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            )

            
        ;

        $mailer->send($message);




        return $this->render('emails/envoi.html.twig', []);
    }
}