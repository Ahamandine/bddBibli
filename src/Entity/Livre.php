<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 190)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    private ?int $annee_edition = null;

    #[ORM\Column]
    private ?int $nombre_pages = null;

    #[ORM\Column(length: 190, nullable: true)]
    private ?string $code_isbn = null;

    #[ORM\ManyToMany(targetEntity: Genre::class, mappedBy: 'livres')]
    private Collection $genres;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auteur $auteurs = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Emprunt::class)]
    private Collection $emprunt;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->emprunt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnneeEdition(): ?int
    {
        return $this->annee_edition;
    }

    public function setAnneeEdition(?int $annee_edition): self
    {
        $this->annee_edition = $annee_edition;

        return $this;
    }

    public function getNombrePages(): ?int
    {
        return $this->nombre_pages;
    }

    public function setNombrePages(int $nombre_pages): self
    {
        $this->nombre_pages = $nombre_pages;

        return $this;
    }

    public function getCodeIsbn(): ?string
    {
        return $this->code_isbn;
    }

    public function setCodeIsbn(?string $code_isbn): self
    {
        $this->code_isbn = $code_isbn;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addLivre($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeLivre($this);
        }

        return $this;
    }

    public function getAuteurs(): ?Auteur
    {
        return $this->auteurs;
    }

    public function setAuteurs(?Auteur $auteurs): self
    {
        $this->auteurs = $auteurs;

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunt(): Collection
    {
        return $this->emprunt;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunt->contains($emprunt)) {
            $this->emprunt->add($emprunt);
            $emprunt->setLivre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunt->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLivre() === $this) {
                $emprunt->setLivre(null);
            }
        }

        return $this;
    }
}
