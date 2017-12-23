<?php
/**
 * Created by PhpStorm.
 * User: Sofyann
 * Date: 21/12/2017
 * Time: 17:32
 */

namespace AppBundle\Service;


use function array_push;
use DateTime;
use function intval;
use function sizeof;

class CalculPrixParVisiteur {
    private $prixTotal;

    public function calculPrixEnFonctionDeLAge($visiteurs = []){
        $aujourdhui = new DateTime();

        for ($i = 0; $i < sizeof($visiteurs); $i++){
            $age = $aujourdhui->diff($visiteurs[$i]["date_de_naissance"])->format('%y');
            $age = intval($age);
            $prix = 0;
            if ($age < 4){
                $prix = 0;
            } elseif ($age < 12){
                $prix = 8;
            } elseif ($age >= 12 && $age < 60){
                $prix = 16;
            } elseif ($age >= 60){
                $prix = 12;
            }

            if ($visiteurs[$i]['tarif_reduit'] == 'tarifReduit'){
                $prix -= 10;
                if ($prix < 0){
                    $prix = 0;
                }
            }
            $this->prixTotal += $prix;
            array_push($visiteurs[$i], $prix);
        }
        return $visiteurs;
    }

    /**
     * @return mixed
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }


}