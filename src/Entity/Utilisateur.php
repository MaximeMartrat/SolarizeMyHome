<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column]
    private ?float $longueur_toit = null;

    #[ORM\Column]
    private ?float $largeur_toit = null;

    #[ORM\Column]
    private ?int $facture = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Calcul $calcul = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getLongueurToit(): ?float
    {
        return $this->longueur_toit;
    }

    public function setLongueurToit(float $longueur_toit): static
    {
        $this->longueur_toit = $longueur_toit;

        return $this;
    }

    public function getLargeurToit(): ?float
    {
        return $this->largeur_toit;
    }

    public function setLargeurToit(float $largeur_toit): static
    {
        $this->largeur_toit = $largeur_toit;

        return $this;
    }

    public function getFacture(): ?int
    {
        return $this->facture;
    }

    public function setFacture(int $facture): static
    {
        $this->facture = $facture;

        return $this;
    }

    public function getCalcul(): ?Calcul
    {
        return $this->calcul;
    }

    public function setCalcul(?Calcul $calcul): static
    {
        // unset the owning side of the relation if necessary
        if ($calcul === null && $this->calcul !== null) {
            $this->calcul->setUtilisateur(null);
        }

        // set the owning side of the relation if necessary
        if ($calcul !== null && $calcul->getUtilisateur() !== $this) {
            $calcul->setUtilisateur($this);
        }

        $this->calcul = $calcul;

        return $this;
    }
}
