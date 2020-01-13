<?php


namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\Produit;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController
{
    public function index() {

        $database = $this->getDoctrine()->getManager();
        $categories = $database->getRepository(Categorie::class)->findAll();
          return $this->render('boutique.html.twig', [
              'categories' => $categories
          ]);
 }


    public function rayon($idCategorie){
        $database = $this->getDoctrine()->getManager();
        $categorie = $database->getRepository(Categorie::class)->find($idCategorie);
        $produits = $categorie->getProduits();
        return $this->render('rayons.html.twig', [
            'produits' => $produits,
            'categorie' => $categorie
        ]);
    }

    public function chercher($texte){
        $produits =$this->getDoctrine()->getRepository(Produit::class)->findProduitsByLibelleOrTexte($texte);
        return $this->render('rayons.html.twig', [
            'produits' => $produits,
            'recherche' => $texte
        ]);
    }
}