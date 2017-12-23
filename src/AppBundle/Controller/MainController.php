<?php

namespace AppBundle\Controller;

use AppBundle\Form\CommandeType;
use AppBundle\Form\Coordonnee;
use AppBundle\Service\CalculPrixParVisiteur;
use DateTime;
use function dump;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: Sofyann
 * Date: 15/12/2017
 * Time: 15:29
 */

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function homeAction(Request $request){
        $form = $this->createForm(CommandeType::class);
        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $visiteurs = $data['visiteurs'];
                $calculateur = new CalculPrixParVisiteur();
                $visiteurs = $calculateur->calculPrixEnFonctionDeLAge($visiteurs);
                $prixTotal = $calculateur->getPrixTotal();


                $session = $request->getSession();
                $session->set('date', $data['date']);
                $session->set('duree', $data['duree']);
                $session->set('visiteurs', $visiteurs);
                $session->set('prixTotal', $prixTotal);

                return $this->redirectToRoute('purchase');
            }
        }

            return $this->render('home.html.twig', [
                'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/purchase/step1", name="purchase")
     */
    public function purchaseAction(Request $request){
        $session = $request->getSession();
        $date = $session->get('date');
        $duree = $session->get('duree');
        $visiteurs =$session->get('visiteurs');
        $prixTotal = $session->get('prixTotal');


        return $this->render('purchaseTunnel.html.twig',[
            'date' => $date,
            'duree' => $duree,
            'visiteurs' => $visiteurs,
            'prixTotal' => $prixTotal
            ]);
    }

    /**
     * @Route("/purchase/step2", name="coordonnee")
     */
    public function purchaseStep2Action(Request $request){

        $form = $this->createForm(Coordonnee::class);
        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();

                $commanditaire = [
                    'prenom' => $data['prenom'],
                    'nom' => $data['nom'],
                    'mail' => $data['mail'],
                    'num' => $data['num'],
                    'adresse' => $data['adresse'],
                    'codePostal' => $data['codePostal'],
                    'ville' => $data['ville'],
                    'pays' => $data['pays'],
                ];

                $session = $request->getSession();
                $session->set('commanditaire', $commanditaire);

                dump($session->get('commanditaire'));

                return $this->redirectToRoute('paiement');
            }
        }


        return $this->render('coordonnee.html.twig', [
            'coordForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/purchase/step3", name="paiement")
     */
    public function purchaseStep3Action(){

        return $this->render('paiement.html.twig');
    }
}