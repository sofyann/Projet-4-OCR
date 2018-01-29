<?php
/**
 * Created by PhpStorm.
 * User: Sofyann
 * Date: 12/01/2018
 * Time: 16:52
 */

namespace AppBundle\Service;


use AppBundle\Entity\Billet;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Commanditaire;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use function dump;
use function getdate;
use function sizeof;
use function substr;

class BddOrder
{
    private $purchase;
    private $em;
    private $reservationCode;
    /**
     * BddOrder constructor.
     * @param $purchase
     * @param $em
     */
    public function __construct(PurchaseData $purchase, EntityManagerInterface $em)
    {
        $this->purchase = $purchase;
        $this->em = $em;
    }

    public function saveData(){
       $commanditaire =  $this->purchase->getBuyer();
       $commande = $this->purchase->getOrder();
       $billets = $commande['visiteurs'];
       $dateCommande = new \DateTime('now');
       $this->generateReservationCode($commanditaire['nom'], $commanditaire['prenom'], $dateCommande);

       $commanditaireBdd = new Commanditaire();
       $commandeBdd = new Commande();


       $commanditaireBdd->setNom($commanditaire['nom']);
       $commanditaireBdd->setPrenom($commanditaire['prenom']);
       $commanditaireBdd->setAdresse($commanditaire['adresse']);
       $commanditaireBdd->setPays($commanditaire['pays']);
       $commanditaireBdd->setVille($commanditaire['ville']);
       $commanditaireBdd->setCodePostal($commanditaire['codePostal']);
       $commanditaireBdd->setPhone($commanditaire['num']);
       $commanditaireBdd->setEmail($commanditaire['mail']);




       $commandeBdd->setDateDeCommande($dateCommande);
       $commandeBdd->setDateDeVisite($commande['date']);
       $commandeBdd->setPrixTotal($commande['prixTotal']);
       $commandeBdd->setDuree($commande['duree']);
       $commandeBdd->setCodeReservation($this->reservationCode);
       $commandeBdd->setCommanditaire($commanditaireBdd);

       $this->em->persist($commanditaireBdd);
       $this->em->persist($commandeBdd);

       for ($i = 0; $i < sizeof($billets); $i++){
           $billetsBdd = new Billet();
           $billetsBdd->setNom($billets[$i]['nom']);
           $billetsBdd->setPrenom($billets[$i]['prenom']);
           $billetsBdd->setDateDeNaissance($billets[$i]['date_de_naissance']);
           $billetsBdd->setTarifReduit($billets[$i]['tarif_reduit']);
           $billetsBdd->setCommande($commandeBdd);
           $this->em->persist($billetsBdd);
       }

       $this->em->flush();
    }


    private function generateReservationCode($nom, $prenom, DateTime $date){
      $derniereCommande = $this->em->getRepository('AppBundle:Commande')->findLastOne();
        if ($derniereCommande == null || $derniereCommande == 0){
            $derniereCommande = 1;
        } else {
            $derniereCommande = $derniereCommande[0]->getId()+1;

        }

      $date = getdate($date->getTimestamp());
      $this->reservationCode =
           $derniereCommande
          .substr($nom,0,1)
          .substr($prenom,0,1)
          .$date['mday']
          .$date['mon']
          .$date['year']
          .$date['hours']
          .$date['minutes'];
    }

    public function getReservationCode(){
        return $this->reservationCode;
    }
}