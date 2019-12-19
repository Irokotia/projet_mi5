<?php


namespace App\Controller;


use App\Entity\Produit;
use App\Entity\Usager;
use App\Service\BoutiqueService;
use App\Service\PanierService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public function index(PanierService $panierService) {

        $contenu = $panierService->getContenu();
        $produits = array();
        foreach ($contenu as $key => $value){
            $produit = $this->getDoctrine()->getRepository(Produit::class)->find($key);
            array_push($produits,$produit);
        }

        return $this->render('panier.html.twig',array(
            'panier' => $panierService->getContenu(),
            'total' => $panierService->getTotal(),
            'produits' => $produits,
            'nbProduit' => $panierService->getNbProduits()
        ));
    }

    public function ajouter(PanierService $panierService,$idProduit,$quantite){

        $panierService->ajouterProduit($idProduit,$quantite);
        return $this->redirectToRoute('panier_index',array('panier',$panierService->getContenu()));
    }

    public function vider(PanierService $panierService){
        $panierService->vider();
        return $this->redirectToRoute('panier_index',array('panier',$panierService->getContenu()));
    }

    public function supprimer(PanierService $panierService,$idProduit){

        $panierService->supprimerProduit($idProduit);
        return $this->redirectToRoute('panier_index',array('panier',$panierService->getContenu()));
    }

    public function enlever(PanierService $panierService,$idProduit,$quantite){

        $panierService->enleverProduit($idProduit,$quantite);
        return $this->redirectToRoute('panier_index',array('panier',$panierService->getContenu()));
    }


    public function validation(PanierService $panierService,EntityManagerInterface $entityManager){

        $idusager = $this->get('session')->get('idusager');
        $usager = $entityManager->getRepository(Usager::class)->findOneBy(array(
            'id' => $idusager
        ));
        $commande = $panierService->panierToCommande($usager,$entityManager);

        return $this->render('commande.html.twig',array(
            'panier' => $panierService->getContenu(),
            'commande' => $commande,
            'nbProduit' => $panierService->getNbProduits()
        ));
    }

}