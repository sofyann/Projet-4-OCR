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
use function dump;
use function intval;
use function sizeof;

class PriceService {
    private $totalPrice;

    public function setRateFor($visitors = []){
        $now = new DateTime();

        for ($i = 0; $i < sizeof($visitors); $i++){
            $age = $now->diff($visitors[$i]["date_de_naissance"])->format('%y');
            $age = intval($age);
            $price = 0;
            if ($age < 4){
                $price = 0;
            } elseif ($age < 12){
                $price = 8;
            } elseif ($age >= 12 && $age < 60){
                $price = 16;
            } elseif ($age >= 60){
                $price = 12;
            }
            if ($visitors[$i]['tarif_reduit'] == true){
                $price -= 10;
                if ($price < 0){
                    $price = 0;
                }
            }
            $this->totalPrice += $price;
            array_push($visitors[$i], $price);
        }
        return $visitors;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }


}