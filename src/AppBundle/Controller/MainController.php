<?php

namespace AppBundle\Controller;

use AppBundle\Form\CommandeType;
use AppBundle\Form\Coordonnee;
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
                $purchaseData = $this->get('app.purchase_data');
                $purchaseData->setOrder($data);
                $purchaseData->updateStep(1);
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
            $purchaseData = $this->get('app.purchase_data');
            $orderDetails = $purchaseData->getOrder();
            $purchaseData->updateStep(2);
            return $this->render('purchaseTunnel.html.twig',[
                'date' => $orderDetails['date'],
                'duree' => $orderDetails['duree'],
                'visiteurs' => $orderDetails['visiteurs'],
                'prixTotal' => $orderDetails['prixTotal']
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
                    $purchaseData = $this->get('app.purchase_data');
                    $purchaseData->setBuyer($data);
                    $purchaseData->updateStep(3);
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
                        "source" => $token,
                        "description" => "Réservation musée du louvre"
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
    public function purchaseStep4Action(Request $request)
    {
        $session = $request->getSession();
        if ($session->get('step') != 4) {
            $session->set('step', 0);
            return $this->redirectToRoute('main');
        } else {
            $email = $session->get('commanditaire');
            $email = $email['mail'];
            $purchaseData = $this->get('app.purchase_data');
            $purchaseData->clearData();
            return $this->render('confirmation.html.twig', [
                'mail' => $email
            ]);
        }
    }
}