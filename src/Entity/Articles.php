<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $detail = null;

    #[ORM\Column(type: 'text')]
    private ?string $specification = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: 'boolean')]
    private bool $aLaUne = false;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    /**
     * @var Collection<int, Tailles>
     */
    #[ORM\ManyToMany(targetEntity: Tailles::class, mappedBy: 'article')]
    private Collection $tailles;

    /**
     * @var Collection<int, Couleurs>
     */
    #[ORM\ManyToMany(targetEntity: Couleurs::class, mappedBy: 'article')]
    private Collection $couleurs;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'article')]
    private Collection $paniers;

    /**
     * @var Collection<int, CommandeLigne>
     */
    #[ORM\OneToMany(targetEntity: CommandeLigne::class, mappedBy: 'article')]
    private Collection $commandeLignes;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Types $type = null;

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
        $this->couleurs = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->commandeLignes = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getSpecification(): ?string
    {
        return $this->specification;
    }

    public function setSpecification(string $specification): static
    {
        $this->specification = $specification;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }
    public function isALaUne(): bool
    {
        return $this->aLaUne;
    }

    public function setALaUne(bool $aLaUne): self
    {
        $this->aLaUne = $aLaUne;
        return $this;
    }
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Collection<int, Tailles>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Tailles $taille): static
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles->add($taille);
            $taille->addArticle($this);
        }

        return $this;
    }

    public function removeTaille(Tailles $taille): static
    {
        if ($this->tailles->removeElement($taille)) {
            $taille->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Couleurs>
     */
    public function getCouleurs(): Collection
    {
        return $this->couleurs;
    }

    public function addCouleur(Couleurs $couleur): static
    {
        if (!$this->couleurs->contains($couleur)) {
            $this->couleurs->add($couleur);
            $couleur->addArticle($this);
        }

        return $this;
    }

    public function removeCouleur(Couleurs $couleur): static
    {
        if ($this->couleurs->removeElement($couleur)) {
            $couleur->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }
    public function addPanier(Panier $panier): static{
    if (!$this->paniers->contains($panier)) {
        $this->paniers[] = $panier;
        $panier->setArticle($this);
    }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
           
            if ($panier->getArticle() === $this) {
                $panier->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeLigne>
     */
    public function getCommandeLignes(): Collection
    {
        return $this->commandeLignes;
    }

    public function addCommandeLigne(CommandeLigne $commandeLigne): static
    {
        if (!$this->commandeLignes->contains($commandeLigne)) {
            $this->commandeLignes->add($commandeLigne);
            $commandeLigne->setArticle($this);
        }

        return $this;
    }

    public function removeCommandeLigne(CommandeLigne $commandeLigne): static
    {
        if ($this->commandeLignes->removeElement($commandeLigne)) {
            // set the owning side to null (unless already changed)
            if ($commandeLigne->getArticle() === $this) {
                $commandeLigne->setArticle(null);
            }
        }

        return $this;
    }

    public function getType(): ?Types
    {
        return $this->type;
    }

    public function setType(?Types $type): static
    {
        $this->type = $type;

        return $this;
    }
}

