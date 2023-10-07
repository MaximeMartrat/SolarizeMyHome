<?php

namespace App\Controller;

use App\Entity\Calcul;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstallationPhotovoltaiqueController extends AbstractController
{

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
