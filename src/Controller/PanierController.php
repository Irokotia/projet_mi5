<?php


namespace App\Controller;


use App\Entity\Produit;
use App\Entity\Usager;
use App\Service\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public function index(PanierService $panierService,EntityManagerInterface $entityManager) {

        $contenu = $panierService->getContenu();
        $produits = array();
        if(isset($contenu)) {
            foreach ($contenu as $key => $value) {
                $produit = $this->getDoctrine()->getRepository(Produit::class)->find($key);
                array_push($produits, $produit);
            }
        }

        return $this->render('panier.html.twig',array(
            'panier' => $panierService->getContenu(),
            'total' => $panierService->getTotal($entityManager),
            'produits' => $produits
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

        $user = $this->getUser();
        $commande = $panierService->panierToCommande($user,$entityManager);

        return $this->render('commande.html.twig',array(
            'panier' => $panierService->getContenu(),
            'commande' => $commande
        ));
    }

}