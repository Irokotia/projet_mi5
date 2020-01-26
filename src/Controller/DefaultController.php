<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\LigneCommandeRepository;


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

    public function topVente(LigneCommandeRepository $ligneCommandeRepository,ProduitRepository $produitRepository){


        $topventes = $ligneCommandeRepository->getTopVentes();

        $produits = array();
        foreach ($topventes as $vente){
            array_push($produits,$produitRepository->find($vente[1]));
        }
        return $this->render('sidebar.html.twig',[
            'topventes' => $topventes,
            'produits' => $produits
        ]);
    }

}
