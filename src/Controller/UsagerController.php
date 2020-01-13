<?php

namespace App\Controller;

use App\Entity\Usager;
use App\Form\UsagerType;
use App\Repository\UsagerRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/usager")
 */
class UsagerController extends AbstractController
{
    const ID_USAGER_SESSION = 'idusager'; // Le nom de la variable d'usager de session
    public function index(UsagerRepository $usagerRepository): Response
    {

        $idUsager = $this->get('session')->get(self::ID_USAGER_SESSION,'');

        return $this->render('usager/index.html.twig', [
            'usager' => $usagerRepository->findOneBy(array(
                'id' => $idUsager))
        ]);
    }
    public function new(Request $request, SessionInterface $session, UserPasswordEncoderInterface
    $passwordEncoder): Response
    {
        $usager = new Usager();
        $form = $this->createForm(UsagerType::class, $usager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encryptage du mot de passe
            $usager->setPassword($passwordEncoder->encodePassword($usager,$usager->getPassword()));
            // Définition du rôle
            $usager->setRoles(["ROLE_CLIENT"]);
            // persistance
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usager);
            $entityManager->flush();
            $session->set(self::ID_USAGER_SESSION,$usager->getId());
            return $this->redirectToRoute('usager_accueil');
        }

        return $this->render('usager/new.html.twig', [
            'usager' => $usager,
            'form' => $form->createView()
        ]);
    }
}
