<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', 'accueil.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('accueil.html.twig');
    }
}