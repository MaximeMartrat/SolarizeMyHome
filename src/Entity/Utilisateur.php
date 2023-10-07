<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?int $facture = null;

    #[ORM\Column(nullable: true)]
    private ?float $longueur_toit = null;

    #[ORM\Column(nullable: true)]
    private ?float $largeur_toit = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Calcul $calcul = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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
