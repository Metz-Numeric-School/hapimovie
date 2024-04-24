<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $fullname = null;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'actors')]
    private Collection $playedMovies;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'directors')]
    private Collection $directedMovies;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'producers')]
    private Collection $producedMovies;

    public function __construct()
    {
        $this->playedMovies = new ArrayCollection();
        $this->directedMovies = new ArrayCollection();
        $this->producedMovies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getPlayedMovies(): Collection
    {
        return $this->playedMovies;
    }

    public function addPlayedMovie(Movie $playedMovie): static
    {
        if (!$this->playedMovies->contains($playedMovie)) {
            $this->playedMovies->add($playedMovie);
            $playedMovie->addActor($this);
        }

        return $this;
    }

    public function removePlayedMovie(Movie $playedMovie): static
    {
        if ($this->playedMovies->removeElement($playedMovie)) {
            $playedMovie->removeActor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getDirectedMovies(): Collection
    {
        return $this->directedMovies;
    }

    public function addDirectedMovie(Movie $directedMovie): static
    {
        if (!$this->directedMovies->contains($directedMovie)) {
            $this->directedMovies->add($directedMovie);
            $directedMovie->addDirector($this);
        }

        return $this;
    }

    public function removeDirectedMovie(Movie $directedMovie): static
    {
        if ($this->directedMovies->removeElement($directedMovie)) {
            $directedMovie->removeDirector($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getProducedMovies(): Collection
    {
        return $this->producedMovies;
    }

    public function addProducedMovie(Movie $producedMovie): static
    {
        if (!$this->producedMovies->contains($producedMovie)) {
            $this->producedMovies->add($producedMovie);
            $producedMovie->addProducer($this);
        }

        return $this;
    }

    public function removeProducedMovie(Movie $producedMovie): static
    {
        if ($this->producedMovies->removeElement($producedMovie)) {
            $producedMovie->removeProducer($this);
        }

        return $this;
    }
}
