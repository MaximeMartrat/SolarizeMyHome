<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Calcul;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', 'accueil.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    { // Supprimez toutes les entités Calcul de la base de données
        $utilisateurRepository = $entityManager->getRepository(Utilisateur::class);
        $calculRepository = $entityManager->getRepository(Calcul::class);
        $utilisateurs = $utilisateurRepository->findAll();
        $calculs = $calculRepository->findAll();
        
        foreach ($utilisateurs as $utilisateur) {
            $entityManager->remove($utilisateur);
        }
        $entityManager->flush();

        foreach ($calculs as $calcul) {
            $entityManager->remove($calcul);
        }

        // Exécutez les suppressions dans la base de données
        $entityManager->flush();
        return $this->render('accueil.html.twig');
    }
}