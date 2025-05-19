<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $detail = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $specification = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

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
    private Collection $taille;

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
        $this->couleurs = new ArrayCollection();
        $this->taille = new ArrayCollection();
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
    public function getTaille(): Collection
    {
        return $this->taille;
    }
}

