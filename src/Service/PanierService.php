<?php


// src/Service/PanierService.php
namespace App\Service;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\Produit;
use App\Entity\Usager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function __construct(SessionInterface $session)
    {
        // Récupération des services session
        $this->session = $session;
        // Récupération du panier en session s'il existe, init. à vide sinon
        $this->panier = $session->get(self::PANIER_SESSION, array());// initialisation du Panier
    }
    // getContenu renvoie le contenu du panier
    // tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu()
    {
        return $this->session->get(self::PANIER_SESSION);
    }

    // getTotal renvoie le montant total du panier
    public function getTotal(EntityManagerInterface $entityManager)
    {
        $total = 0.0;
        if($this->session->get(self::PANIER_SESSION)) {
            foreach ($this->session->get(self::PANIER_SESSION) as $key => $value) {
                $produitobj = $entityManager->getRepository(Produit::class)->find($key);
                $total += $value * $produitobj->getPrix();
            }
        }
        return $total;
    }

    // getNbProduits renvoie le nombre de produits dans le panier
    public function getNbProduits()
    {
        $nbProduits = 0;
        if(!empty($this->session->get(self::PANIER_SESSION))){
            foreach($this->session->get(self::PANIER_SESSION) as $produit){
                $nbProduits += $produit;
            }
            return $nbProduits;
        }else{
            return 0;
        }
    }

    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
    public function ajouterProduit(int $idProduit, int $quantite = 1)
    {
        $this->panier[$idProduit] = $quantite;

        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public function enleverProduit(int $idProduit, int $quantite = 1)
    {
        $this->panier[$idProduit] = $this->panier[$idProduit] - $quantite;

        var_dump($this->panier);
        if($this->panier[$idProduit] <= 0) {
            if(array_key_exists($idProduit,$this->panier)){
                unset($this->panier[$idProduit]);
            }
        }
        if(!isset($this->panier)){
            $this->panier = [];
        }
        $this->session->set(self::PANIER_SESSION,$this->panier);
    }

    // supprimerProduit supprime complètement le produit $idProduit du panier
    public function supprimerProduit(int $idProduit)
    {
        if(array_key_exists($idProduit,$this->panier)){
            unset($this->panier[$idProduit]);
        }
        if(!isset($this->panier)){
            $this->panier = [];
        }
     $this->session->set(self::PANIER_SESSION,$this->panier);
    }

    // vider vide complètement le panier
    public function vider()
    {
        $this->session->set(self::PANIER_SESSION,[]);
    }

    public function panierToCommande(Usager $usager, EntityManagerInterface $entityManager){

        $commande = new Commande();
        if(count($this->session->get(self::PANIER_SESSION)) > 0){
            $commande->setDateCommande(new \DateTime());
            $commande->setStatut("En cours");
            $commande->setUsager($usager);
            $entityManager->persist($commande);
            $entityManager->flush();
            foreach($this->session->get(self::PANIER_SESSION) as $key => $value ){
                $produitobj = $entityManager->getRepository(Produit::class)->find($key);
                $ligneCommande = new LigneCommande();
                $ligneCommande->setProduit($produitobj);
                $ligneCommande->setCommande($commande);
                $ligneCommande->setPrix( ($produitobj->getPrix() * $value ));
                $ligneCommande->setQuantite($value);
                $entityManager->persist($ligneCommande);
                $entityManager->flush();
            }
        }

        $this->session->set(self::PANIER_SESSION,[]);
        return $commande;
    }
}
