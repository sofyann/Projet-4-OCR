<?php
namespace AppBundle\Service;
use AppBundle\Entity\Visitor;
use DateTime;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Service\PriceService;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Created by PhpStorm.
 * User: Sofyann
 * Date: 05/02/2018
 * Time: 08:47
 */

class PriceServiceTest extends WebTestCase
{
    public function testGivenA4YearOldVisitor_WhenPriceServiceSetrate_ThenItsPriceIsEqualTo0(){
        // Given
        $priceService  = new PriceService();
        $visitor1 = new Visitor();
        $visitor1->setPrenom('Prenom test1');
        $visitor1->setNom('Nom test1');
        $visitor1->setPays('France');
        $visitor1->setTarifReduit(false);
        $visitor1->setDateDeNaissance(new \DateTime('2017-11-06'));
        $visitors = [
            0 => [
                'nom' => $visitor1->getNom(),
                'prenom' => $visitor1->getPrenom(),
                'pays' => $visitor1->getPays(),
                'tarif_reduit' => false,
                'date_de_naissance' => $visitor1->getDateDeNaissance()
            ]
        ];

        // When
        $result = $priceService->setRateFor($visitors);



        // Then
        $this->assertEquals($result[0][0], 0);
    }

    public function testGivenA21YearOldVisitor_WhenPriceServiceSetrate_ThenItsPriceIsEqualTo16(){
        // Given
        $priceService  = new PriceService();
        $visitor1 = new Visitor();
        $visitor1->setPrenom('Prenom test1');
        $visitor1->setNom('Nom test1');
        $visitor1->setPays('France');
        $visitor1->setTarifReduit(false);
        $visitor1->setDateDeNaissance(new \DateTime('1996-11-06'));
        $visitors = [
            0 => [
                'nom' => $visitor1->getNom(),
                'prenom' => $visitor1->getPrenom(),
                'pays' => $visitor1->getPays(),
                'tarif_reduit' => false,
                'date_de_naissance' => $visitor1->getDateDeNaissance()
            ]
        ];

        // When
        $result = $priceService->setRateFor($visitors);



        // Then
        $this->assertEquals($result[0][0], 16);
    }

    public function testGivenA8YearOldVisitor_WhenPriceServiceSetrate_ThenItsPriceIsEqualTo8(){
        // Given
        $priceService  = new PriceService();
        $visitor1 = new Visitor();
        $visitor1->setPrenom('Prenom test1');
        $visitor1->setNom('Nom test1');
        $visitor1->setPays('France');
        $visitor1->setTarifReduit(false);
        $visitor1->setDateDeNaissance(new \DateTime('2010-11-06'));
        $visitors = [
            0 => [
                'nom' => $visitor1->getNom(),
                'prenom' => $visitor1->getPrenom(),
                'pays' => $visitor1->getPays(),
                'tarif_reduit' => false,
                'date_de_naissance' => $visitor1->getDateDeNaissance()
            ]
        ];

        // When
        $result = $priceService->setRateFor($visitors);

        // Then
        $this->assertEquals($result[0][0], 8);
    }
    public function testGivenA60YearOldVisitor_WhenPriceServiceSetrate_ThenItsPriceIsEqualTo12(){
        // Given
        $priceService  = new PriceService();
        $visitor1 = new Visitor();
        $visitor1->setPrenom('Prenom test1');
        $visitor1->setNom('Nom test1');
        $visitor1->setPays('France');
        $visitor1->setTarifReduit(false);
        $visitor1->setDateDeNaissance(new \DateTime('1957-11-06'));
        $visitors = [
            0 => [
                'nom' => $visitor1->getNom(),
                'prenom' => $visitor1->getPrenom(),
                'pays' => $visitor1->getPays(),
                'tarif_reduit' => false,
                'date_de_naissance' => $visitor1->getDateDeNaissance()
            ]
        ];

        // When
        $result = $priceService->setRateFor($visitors);

        // Then
        $this->assertEquals($result[0][0], 12);
    }
    public function testGivenA21YearOldVisitorWithTarifReduitEqualToTrue_WhenPriceServiceSetrate_ThenItsPriceIsEqualTo6(){
        // Given
        $priceService  = new PriceService();
        $visitor1 = new Visitor();
        $visitor1->setPrenom('Prenom test1');
        $visitor1->setNom('Nom test1');
        $visitor1->setPays('France');
        $visitor1->setTarifReduit(false);
        $visitor1->setDateDeNaissance(new \DateTime('1996-11-06'));
        $visitors = [
            0 => [
                'nom' => $visitor1->getNom(),
                'prenom' => $visitor1->getPrenom(),
                'pays' => $visitor1->getPays(),
                'tarif_reduit' => true,
                'date_de_naissance' => $visitor1->getDateDeNaissance()
            ]
        ];

        // When
        $result = $priceService->setRateFor($visitors);

        // Then
        $this->assertEquals($result[0][0], 6);
    }
}