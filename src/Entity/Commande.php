<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeLigne::class, cascade: ['persist'], orphanRemoval: true, fetch: 'EAGER')]
    private Collection $commandeLignes;

    #[ORM\ManyToOne(inversedBy: 'commandes', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $status = 'En attente';

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rue = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


    public function __construct()
    {
        $this->commandeLignes = new ArrayCollection();
        $this->status = 'en attente';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getNumero(): ?string
    {

        return $this->numero;
    }
    public function setNumero(?string $numero): static
    {

        $this->numero = $numero;
        return $this;
    }

    public function getRue(): ?string
    {

        return $this->rue;
    }
    public function setRue(?string $rue): static
    {

        $this->rue = $rue;
        return $this;
    }

    public function getCodePostal(): ?string
    {

        return $this->codePostal;
    }
    public function setCodePostal(?string $codePostal): static
    {

        $this->codePostal = $codePostal;
        return $this;
    }

    public function getVille(): ?string
    {

        return $this->ville;
    }
    public function setVille(?string $ville): static
    {

        $this->ville = $ville;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getCommandeLignes(): Collection
    {
        return $this->commandeLignes;
    }

    public function addCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if (!$this->commandeLignes->contains($commandeLigne)) {
            $this->commandeLignes[] = $commandeLigne;
            $commandeLigne->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if ($this->commandeLignes->removeElement($commandeLigne)) {
            if ($commandeLigne->getCommande() === $this) {
                $commandeLigne->setCommande(null);
            }
        }

        return $this;
    }
    public function getArticlesList(): string
    {
        $titre = [];

        foreach ($this->commandeLignes as $ligne) {
            $article = $ligne->getArticle();
            if ($article) {
                $titre[] = $article->getTitre();
            }
        }

        return implode(', ', $titre);
    }
    public function getAdresseComplete(): string
    {
        return sprintf('%s %s, %s %s', $this->numero, $this->rue, $this->codePostal, $this->ville);
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'en_attente' => 'En attente',
            'livrée' => 'Livrée',
            'annulée' => 'Annulée',
            default => ucfirst($this->status),
        };
    }


}
