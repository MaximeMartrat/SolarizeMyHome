<?php

namespace App\Controller;

use App\Entity\Calcul;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class AccueilController extends AbstractController
{
    #[Route('/', 'accueil.index', methods: ['GET'])]
   public function index(EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            // Recherche des informations dans la BDD en fonction de l'utilisateur
            $calculRepository = $entityManager->getRepository(Calcul::class);
            $calcul = $calculRepository->findOneBy(['utilisateur' => $this->getUser()]);
            // Si utilisateur est connecté, redirection vers la page des résultats
            return $this->redirectToRoute('resultats_calculs', ['calculId' => $calcul->getId()]);
        }

        // Si utilisateur n'est pas connecté, affichage de la page d'accueil
        return $this->render('accueil.html.twig');
    }
}