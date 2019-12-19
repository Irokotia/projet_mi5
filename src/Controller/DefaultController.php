<?php

namespace App\Controller;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController {

    public function index(PanierService $panierService) {
        return $this->render('home.html.twig',array(
            'nbProduit' => $panierService->getNbProduits()
        ));
    }


    public function contact(PanierService $panierService){
        return $this->render('contact.html.twig',array(
            'nbProduit' => $panierService->getNbProduits()
        ));
    }
}