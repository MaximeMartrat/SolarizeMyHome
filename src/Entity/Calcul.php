<?php

namespace App\Entity;

use App\Repository\CalculRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculRepository::class)]
class Calcul
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $consoKWh = null;

    #[ORM\Column(nullable: true)]
    private ?float $puissanceKWC = null;

    #[ORM\Column(nullable: true)]
    private ?float $puissanceWC = null;

    #[ORM\Column(nullable: true)]
    private ?float $productionKWh = null;

    #[ORM\Column(nullable: true)]
    private ?int $panneauxNecessaires = null;

    #[ORM\Column(nullable: true)]
    private ?float $surfaceToitM2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $largeurPanneauM = null;

    #[ORM\Column(nullable: true)]
    private ?float $longueurPanneauM = null;

    #[ORM\OneToOne(mappedBy: 'calcul', cascade: ['persist', 'remove'])]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsoKWh(): ?float
    {
        return $this->consoKWh;
    }

    public function setConsoKWh(float $consoKWh): static
    {
        $this->consoKWh = $consoKWh;

        return $this;
    }

    public function getPuissanceKWC(): ?float
    {
        return $this->puissanceKWC;
    }

    public function setPuissanceKWC(float $puissanceKWC): static
    {
        $this->puissanceKWC = $puissanceKWC;

        return $this;
    }

    public function getPuissanceWC(): ?float
    {
        return $this->puissanceWC;
    }

    public function setPuissanceWC(?float $puissanceWC): static
    {
        $this->puissanceWC = $puissanceWC;

        return $this;
    }

    public function getProductionKWh(): ?float
    {
        return $this->productionKWh;
    }

    public function setProductionKWh(?float $productionKWh): static
    {
        $this->productionKWh = $productionKWh;

        return $this;
    }

    public function getPanneauxNecessaires(): ?float
    {
        return $this->panneauxNecessaires;
    }

    public function setPanneauxNecessaires(?float $panneauxNecessaires): static
    {
        $this->panneauxNecessaires = $panneauxNecessaires;

        return $this;
    }

    public function getSurfaceToitM2(): ?float
    {
        return $this->surfaceToitM2;
    }

    public function setSurfaceToitM2(?float $surfaceToitM2): static
    {
        $this->surfaceToitM2 = $surfaceToitM2;

        return $this;
    }

    public function getLargeurPanneauM(): ?float
    {
        return $this->largeurPanneauM;
    }

    public function setLargeurPanneauM(?float $largeurPanneauM): static
    {
        $this->largeurPanneauM = $largeurPanneauM;

        return $this;
    }

    public function getLongueurPanneauM(): ?float
    {
        return $this->longueurPanneauM;
    }

    public function setLongueurPanneauM(?float $longueurPanneauM): static
    {
        $this->longueurPanneauM = $longueurPanneauM;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        // unset the owning side of the relation if necessary
        if ($utilisateur === null && $this->utilisateur !== null) {
            $this->utilisateur->setCalcul(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateur !== null && $utilisateur->getCalcul() !== $this) {
            $utilisateur->setCalcul($this);
        }

        $this->utilisateur = $utilisateur;

        return $this;
    }
}
