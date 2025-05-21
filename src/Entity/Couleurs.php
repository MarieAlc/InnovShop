<?php

namespace App\Entity;

use App\Repository\CouleursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use app\Entity\Articles;

#[ORM\Entity(repositoryClass: CouleursRepository::class)]
class Couleurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $valeur = null;

    /**
     * @var Collection<int, Articles>
     */
    #[ORM\ManyToMany(targetEntity: Articles::class, inversedBy: 'couleurs')]
    private Collection $article;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'couleur')]
    private Collection $paniers;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Articles $article): static
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
        }

        return $this;
    }

    public function removeArticle(Articles $article): static
    {
        $this->article->removeElement($article);

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setCouleur($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getCouleur() === $this) {
                $panier->setCouleur(null);
            }
        }

        return $this;
    }

     public function __toString(): string
    {
        return $this->valeur; 
    }
}
