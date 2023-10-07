<?php

namespace App\Controller;

// src/Controller/InstallationPhotovoltaiqueController.php

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

        if ($form->isSubmitted() && $form->isValid()) {
            // Les données du formulaire sont valides, vous pouvez les récupérer et effectuer les calculs.
            $data = $form->getData();

            // Créez une instance de Calcul
            $calcul = new Calcul();
            $calcul->setConsoKWH($data->getFacture() / 0.20); // Calcul de la consommation en kWh

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

        return $this->render('installation/resultats_calculs.html.twig', [
            'calcul' => $calcul,
        ]);
    }
}
