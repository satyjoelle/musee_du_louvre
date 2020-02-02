<?php

namespace App\Services;
use DateTime;
use Symfony\Component\HttpFoundation\RequestStack;


class ReservHourBillet

{

    private $_requestStack;

        public function _construct(RequestStack $requestStack)

        {
            $this->requestStack = $requestStack;
        
        }

        public function hourBillet($jour_de_visite,  $type_de_billet)
        {

            $request = $this->requestStack->getCurrentRequest();

            //recuperation du jour de la visite
            $day  = new DateTime(date('m/d/y'));
            $jour_de_visite = new DateTime($jour_de_visite->format('m/d/y'));

            if($jour_de_visite == $day)

            {
                    //Récupération de l'heure
                    date_default_timezone_get('Europe/Paris');
                    $hour = date('H');

                    //test pour le billet journée
                    if ($hour >=14 && $duration ==1)
                    {
                    // Si l'heure est supérieure à 14 h et le type de billet est journée (1) => Erreur
				    $return = 'notHourBillet';
                    return $return;
                    
                    }
                    else {return 'ok';}

                    

            }
            else {return 'ok';}




        }

}




    







