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
    private ?float $consoKWH = null;

    #[ORM\Column(nullable: true)]
    private ?float $puissanceKWC = null;

    #[ORM\Column(nullable: true)]
    private ?float $puissanceWC = null;

    #[ORM\Column(nullable: true)]
    private ?float $productionKWH = null;

    #[ORM\Column(nullable: true)]
    private ?int $panneaux_necessaires = null;

    #[ORM\Column(nullable: true)]
    private ?float $surface_toitM2 = null;

    #[ORM\OneToOne(inversedBy: 'calcul', cascade: ['persist', 'remove'])]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsoKWH(): ?float
    {
        return $this->consoKWH;
    }

    public function setConsoKWH(?float $consoKWH): static
    {
        $this->consoKWH = $consoKWH;

        return $this;
    }

    public function getPuissanceKWC(): ?float
    {
        return $this->puissanceKWC;
    }

    public function setPuissanceKWC(?float $puissanceKWC): static
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

    public function getProductionKWH(): ?float
    {
        return $this->productionKWH;
    }

    public function setProductionKWH(?float $productionKWH): static
    {
        $this->productionKWH = $productionKWH;

        return $this;
    }

    public function getPanneauxNecessaires(): ?int
    {
        return $this->panneaux_necessaires;
    }

    public function setPanneauxNecessaires(?int $panneaux_necessaires): static
    {
        $this->panneaux_necessaires = $panneaux_necessaires;

        return $this;
    }

    public function getSurfaceToitM2(): ?float
    {
        return $this->surface_toitM2;
    }

    public function setSurfaceToitM2(?float $surface_toitM2): static
    {
        $this->surface_toitM2 = $surface_toitM2;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
