<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Calcul;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // instance de Calcul
            $calcul = new Calcul();
            // Calcul de la consommation en kWh
            $calcul->setConsoKWH($user->getFacture() / 0.20);
            //Calcul de la surface du toit
            $calcul->setSurfaceToitM2($user->getLongueurToit() * $user->getLargeurToit());

            // effectuer les autres calculs
            $calcul->calculerDonnees();

            $user->setCalcul($calcul);

            // Enregistrer Calcul en base de données
            $entityManager->persist($calcul);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}