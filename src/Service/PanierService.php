<?php


// src/Service/PanierService.php
namespace App\Service;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\BoutiqueService;
// Service pour manipuler le panier et le stocker en session
class PanierService
{
    ////////////////////////////////////////////////////////////////////////////
    const PANIER_SESSION = 'panier'; // Le nom de la variable de session du panier
    private $session; // Le service Session
    private $boutique; // Le service Boutique
    private $panier; // Tableau associatif idProduit => quantite
    // donc $this->panier[$i] = quantite du produit dont l'id = $i
    // constructeur du service
    public function __construct(SessionInterface $session, BoutiqueService $boutique)
    {
        // Récupération des services session et BoutiqueService
        $this->boutique = $boutique;
        $this->session = $session;
        // Récupération du panier en session s'il existe, init. à vide sinon
        $this->panier = ;// initialisation du Panier : à compléter
    }
    // getContenu renvoie le contenu du panier
    // tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu()
    { // à compléter
    }

    // getTotal renvoie le montant total du panier
    public function getTotal()
    { // à compléter
    }

    // getNbProduits renvoie le nombre de produits dans le panier
    public function getNbProduits()
    { // à compléter
    }

    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
    public function ajouterProduit(int $idProduit, int $quantite = 1)
    { // à compléter
    }

    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public function enleverProduit(int $idProduit, int $quantite = 1)
    { // à compléter
    }

    // supprimerProduit supprime complètement le produit $idProduit du panier
    public function supprimerProduit(int $idProduit)
    { // à compléter
    }

    // vider vide complètement le panier
    public function vider()
    { // à compléter
    }
}