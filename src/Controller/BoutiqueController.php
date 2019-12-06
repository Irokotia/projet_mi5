<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BoutiqueService;

class BoutiqueController extends AbstractController
{
    public function index(BoutiqueService $boutique) {
        $categories = $boutique->findAllCategories();
          return $this->render('boutique.html.twig', [
              'categories' => $categories
          ]);
 }


    public function rayon($idCategorie,BoutiqueService $boutique){
        $rayons = $boutique->findProduitsByCategorie($idCategorie);
        $categorie = $boutique->findCategorieById($idCategorie);
        return $this->render('rayons.html.twig', [
            'produits' => $rayons,
            'categorie' => $categorie
        ]);
    }

    public function chercher($texte,BoutiqueService $boutique){
        $produits = $boutique->findProduitsByLibelleOrTexte($texte);
        return $this->render('rayons.html.twig', [
            'produits' => $produits,
            'recherche' => $texte
        ]);
    }
}