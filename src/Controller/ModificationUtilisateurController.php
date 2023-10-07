<?php

namespace App\Controller;

use App\Entity\Calcul;
use App\Form\ModificationUtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ModificationUtilisateurController extends AbstractController
{
    #[Route('/modification', 'modification', methods: ['GET', 'POST'])]
    public function modifierUtilisateur(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer utilisateur connecté
        $user = $this->getUser(); 

        // Rechercher instance de Calcul associée à utilisateur si existe
        $calcul = $user->getCalcul();

        // Si aucune instance de Calcul n'existe, créer une
        if (!$calcul) {
            $calcul = new Calcul();
        }

        // Créer le formulaire de modification prérempli avec données utilisateur et instance de Calcul
        $form = $this->createForm(ModificationUtilisateurType::class, $user);

        // Traitement de soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mettre à jour utilisateur dans la BDD
            $entityManager->flush();

            // Calcul de la consommation en kWh
            $calcul->setConsoKWH($user->getFacture() / 0.20);
            //Calcul de la surface du toit
            $calcul->setSurfaceToitM2($user->getLongueurToit() * $user->getLargeurToit());
            $calcul->calculerDonnees();
            $user->setCalcul($calcul);

            // Enregistrer Calcul dans BDD
            if (!$calcul->getId()) {
                $entityManager->persist($calcul);
            }

            // MAJ de la table Calcul
            $entityManager->flush();

            // Rediriger vers la page des résultats
            return $this->redirectToRoute('resultats_calculs', [
                'calculId' => $calcul->getId(),
            ]);
        }

        return $this->render('modification/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

