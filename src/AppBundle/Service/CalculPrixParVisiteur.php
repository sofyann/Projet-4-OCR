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

    public function calculPrixEnFonctionDeLAge($visiteurs = []){
        $aujourdhui = new DateTime();
        $prix = [];
        for ($i = 0; $i < sizeof($visiteurs); $i++){
            $age = $aujourdhui->diff($visiteurs[$i]["date_de_naissance"])->format('%y');
            $age = intval($age);
            if ($age < 4){
                array_push($prix,0);
            } elseif ($age < 12){
                array_push($prix,8);
            } elseif ($age >= 12 && $age < 60){
                array_push($prix,16);
            } elseif ($age >= 60){
                array_push($prix,12);
            }
        }
        return $prix;
    }
}