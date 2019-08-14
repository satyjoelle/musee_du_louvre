<?php
/**
 * Created by PhpStorm.
 * User: faveu
 * Date: 12/08/2019
 * Time: 00:33
 */

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
       /* $message = (new \Swift_Message('Hello Email'))
            ->setFrom('adimicool@gmail.com')
            ->setTo('faveurextra@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        $mailer->send($message);

        // ...
        return $this->render('emails/envoi.html.twig', []);
       */

        $message = (new \Swift_Message('Hello Email'))
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

            // you can remove the following code if you don't define a text version for your emails
           /* ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'emails/registration.txt.twig',
                    ['name' => $name]
                ),
                'text/plain'
            )*/
        ;

        $mailer->send($message);




        return $this->render('emails/envoi.html.twig', []);
    }
}