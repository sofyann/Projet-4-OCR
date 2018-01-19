<?php
/**
 * Created by PhpStorm.
 * User: Sofyann
 * Date: 29/12/2017
 * Time: 09:43
 */

namespace AppBundle\Service;


use function dump;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Intl\Intl;

class PurchaseData
{
    private $session;
    private $priceCalc;
    public function __construct(SessionInterface $session, Price $priceCalc)
    {
        $this->session = $session;
        $this->priceCalc = $priceCalc;
    }

    public function setOrder($data){
        $countries = Intl::getRegionBundle()->getCountryNames();
        $visitors = $data['visitors'];
        foreach ($visitors as $visitor){
            $visitor['pays'] = $countries[$visitor['pays']];
        }
        $visitors = $this->priceCalc->priceByAge($visitors);
        $totalPrice = $this->priceCalc->getTotalPrice();
        $this->session->set('date', $data['date']);
        $this->session->set('duree', $data['duree']);
        $this->session->set('visiteurs', $visitors);
        $this->session->set('prixTotal', $totalPrice);
    }



    public function updateStep($step){
        $this->session->set('step', $step);
    }

    public function getOrder(){
        return [
            'date' => $this->session->get('date'),
            'duree' => $this->session->get('duree'),
            'visiteurs' => $this->session->get('visiteurs'),
            'prixTotal' => $this->session->get('prixTotal')
        ];
    }

    public function setBuyer($data){
        $countries = Intl::getRegionBundle()->getCountryNames();
        $commanditaire = [
            'prenom' => $data['prenom'],
            'nom' => $data['nom'],
            'mail' => $data['mail'],
            'num' => $data['num'],
            'adresse' => $data['adresse'],
            'codePostal' => $data['codePostal'],
            'ville' => $data['ville'],
            'pays' => $countries[$data['pays']],
        ];
        $this->session->set('commanditaire', $commanditaire);
    }

    public function getBuyer(){
      return $this->session->get('commanditaire');
    }

    public function clearData(){
        $this->session->set('date', '');
        $this->session->set('duree', '');
        $this->session->set('visiteurs', []);
        $this->session->set('prixTotal', 0);
        $this->session->set('step', 0);
        $this->session->set('commanditaire', []);
    }
}