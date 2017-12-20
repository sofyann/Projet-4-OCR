<?php

namespace AppBundle\Controller;

use AppBundle\Form\CommandeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Created by PhpStorm.
 * User: Sofyann
 * Date: 15/12/2017
 * Time: 15:29
 */

class MainController extends Controller
{

    public function homeAction(){
        $form = $this->createForm(CommandeType::class);
        return $this->render('home.html.twig', [
            'form'=> $form->createView()
        ]);
    }

}