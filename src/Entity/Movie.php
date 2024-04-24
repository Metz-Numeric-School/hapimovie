<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read','create','update'])]
    #[Assert\NotBlank(groups: ['create'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read','create','update'])]
    private ?string $synopsis = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read','create','update'])]
    private ?int $releasedYear = null;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'movies')]
    #[Groups(['read'])]
    private Collection $genres;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\JoinTable("movie_actor")]
    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'playedMovies')]
    private Collection $actors;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\JoinTable("movie_director")]
    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'directedMovies')]
    private Collection $directors;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\JoinTable("movie_producer")]
    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'producedMovies')]
    private Collection $producers;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->directors = new ArrayCollection();
        $this->producers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getReleasedYear(): ?int
    {
        return $this->releasedYear;
    }

    public function setReleasedYear(?int $releasedYear): static
    {
        $this->releasedYear = $releasedYear;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Person $actor): static
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
        }

        return $this;
    }

    public function removeActor(Person $actor): static
    {
        $this->actors->removeElement($actor);

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getDirectors(): Collection
    {
        return $this->directors;
    }

    public function addDirector(Person $director): static
    {
        if (!$this->directors->contains($director)) {
            $this->directors->add($director);
        }

        return $this;
    }

    public function removeDirector(Person $director): static
    {
        $this->directors->removeElement($director);

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getProducers(): Collection
    {
        return $this->producers;
    }

    public function addProducer(Person $producer): static
    {
        if (!$this->producers->contains($producer)) {
            $this->producers->add($producer);
        }

        return $this;
    }

    public function removeProducer(Person $producer): static
    {
        $this->producers->removeElement($producer);

        return $this;
    }
}
