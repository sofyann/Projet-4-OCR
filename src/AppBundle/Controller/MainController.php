<?php

namespace AppBundle\Controller;

use AppBundle\Form\CommandeType;
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
    public function homeAction(){
        $form = $this->createForm(CommandeType::class);
        return $this->render('home.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/purchase/step1", name="purchase")
     */
    public function purchaseAction(Request $request){
        $form = $this->createForm(CommandeType::class);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $date = $data['date'];
                $duree = $data['duree'];
                $visiteurs = $data['visiteurs'];
                $prixParVisiteur = 0;
                $prixTotal = 0;
                dump($visiteurs);
                return $this->render('purchaseTunnel.html.twig', [
                    'date' => $date,
                    'duree' => $duree,
                    'visiteurs' => $visiteurs,
                    'prixParVisiteur' => $prixParVisiteur,
                    'prixTotal' => $prixTotal
                ]);
            }
        } else {
            return $this->redirectToRoute('main');
        }
    }
}