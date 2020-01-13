<?php

namespace App\Controller;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController {

    public function index() {
        return $this->render('home.html.twig');
    }


    public function contact(){
        return $this->render('contact.html.twig');
    }

    public function navBar(PanierService $panierService){

        return $this->render('nbProduits.html.twig',[
            'nbProduits' => $panierService->getNbProduits()
        ]);
    }
}