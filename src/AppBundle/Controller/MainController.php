<?php

namespace AppBundle\Controller;

use AppBundle\Form\CommandeType;
use AppBundle\Form\Coordonnee;
use AppBundle\Service\CalculPrixParVisiteur;
use DateTime;
use function dump;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Mailer;
use Swift_Message;
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
                $session->set('step', 1);
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
        if ($session->get('step') != 1){
            $session->set('step', 0);
            return $this->redirectToRoute('main');
        } else {
            $date = $session->get('date');
            $duree = $session->get('duree');
            $visiteurs =$session->get('visiteurs');
            $prixTotal = $session->get('prixTotal');
            $session->set('step', 2);

            return $this->render('purchaseTunnel.html.twig',[
                'date' => $date,
                'duree' => $duree,
                'visiteurs' => $visiteurs,
                'prixTotal' => $prixTotal
            ]);
        }
    }

    /**
     * @Route("/purchase/step2", name="coordonnee")
     */
    public function purchaseStep2Action(Request $request){
        $session = $request->getSession();
        if ($session->get('step') != 2){
            $session->set('step', 0);
            return $this->redirectToRoute('main');
        } else {
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


                    $session->set('commanditaire', $commanditaire);
                    $session->set('step', 3);
                    return $this->redirectToRoute('paiement');
                }
            }
            return $this->render('coordonnee.html.twig', [
                'coordForm' => $form->createView()
            ]);
        }


    }

    /**
     * @Route("/purchase/step3", name="paiement")
     */
    public function purchaseStep3Action(Request $request, Swift_Mailer $mailer){

        $session = $request->getSession();

        if ($session->get('step') != 3){
            $session->set('step', 0);
            return $this->redirectToRoute('main');
        } else {
            $prixTotal = $session->get('prixTotal');
            $error = false;
            if($request->isMethod('POST')){
                $token = $request->get('stripeToken');
                try{
                    \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

                    \Stripe\Charge::create(array(
                        "amount" => $prixTotal * 100,
                        "currency" => "eur",
                        "source" => $token, // obtained with Stripe.js
                        "description" => "first test charge"
                    ));
                }catch (\Stripe\Error\Card $e){
                    $error = 'Un problème est survenue : votre carte a été refusée.';
                }

                if (!$error){
                    $date = $session->get('date');
                    $duree = $session->get('duree');
                    $visiteurs =$session->get('visiteurs');
                    $email = $session->get('commanditaire');
                    $email = $email['mail'];

                    $message = (new Swift_Message('Hello email'))
                        ->setFrom('Musee-du-Louvre@exemple.fr')
                        ->setTo($email)
                        ->setBody($this->renderView('email.html.twig',[
                            'date' => $date,
                            'duree' => $duree,
                            'visiteurs' => $visiteurs,
                            'prixTotal' => $prixTotal
                        ]), 'text/html');
                     $mailer->send($message);
                    $session->set('step', 4);
                    return $this->redirectToRoute('confirmation');
                }


            }
            return $this->render('paiement.html.twig', [
                'prixTotal' => $prixTotal,
                'error' => $error
            ]);
        }

    }

    /**
     * @Route("/purchase/step4", name="confirmation")
     */
    public function purchaseStep4Action(Request $request){


        return $this->render('confirmation.html.twig');
    }

}