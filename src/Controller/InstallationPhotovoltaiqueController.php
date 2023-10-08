<?php

namespace App\Controller;

// src/Controller/InstallationPhotovoltaiqueController.php
use App\Entity\Utilisateur;
use App\Entity\Calcul;
use App\Form\InstallationPhotovoltaiqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstallationPhotovoltaiqueController extends AbstractController
{
    #[Route('/installation/saisie-donnees', name: 'saisie_donnees', methods: ['GET', 'POST'])]
    public function saisieDonnees(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InstallationPhotovoltaiqueType::class);

        // Traitement de la soumission du formulaire
        $form->handleRequest($request);
        $utilisateur = null;
        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont valides, vous pouvez les récupérer et effectuer les calculs.
            $data = $form->getData();

            // Créez une instance de Utilisateur
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($data->getNom());
            $utilisateur->setPrenom($data->getPrenom());
            $utilisateur->setLongueurToit($data->getLongueurToit());
            $utilisateur->setLargeurToit($data->getLargeurToit());
            $utilisateur->setFacture($data->getFacture());
            // Enregistrez $utilisateur dans la base de données
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            
            // Créez une instance de Calcul
            $calcul = new Calcul();
            $calcul->setConsoKWH($data->getFacture() / 0.20); // Calcul de la consommation en kWh
            $calcul->setSurfaceToitM2($data->getLongueurToit() * $data->getLargeurToit());
            $calcul->setUtilisateur($utilisateur);
            // Utilisez la méthode de l'entité Calcul pour effectuer les autres calculs
            $calcul->calculerDonnees();

            // Enregistrez $calcul dans la base de données
            $entityManager->persist($calcul);
            $entityManager->flush();

            // Redirigez vers la page des résultats des calculs
            return $this->redirectToRoute('resultats_calculs', [
                'calculId' => $calcul->getId(),
            ]);
        }

        return $this->render('installation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/installation/resultats-calculs/{calculId}', name: 'resultats_calculs', methods: ['GET'])]
    public function resultatsCalculs(Request $request, $calculId, EntityManagerInterface $entityManager): Response
    {
        $calcul = $entityManager->getRepository(Calcul::class)->find($calculId);

        if (!$calcul) {
            throw $this->createNotFoundException('Calcul introuvable');
        }
        
        $utilisateur = $calcul->getUtilisateur();

        return $this->render('installation/resultats_calculs.html.twig', [
            'calcul' => $calcul,
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/remove', name: 'remove', methods: ['GET'])]
    public function removeDonnees(EntityManagerInterface $entityManager): Response
    {
        // Supprimez toutes les entités Calcul de la base de données
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

        // Redirigez l'utilisateur vers la page d'accueil
        return $this->redirectToRoute('saisie_donnees');
    }
}