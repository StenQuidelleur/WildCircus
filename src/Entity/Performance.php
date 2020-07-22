<?php

namespace App\Entity;

use App\Repository\PerformanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerformanceRepository::class)
 */
class Performance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryPerf::class, inversedBy="performances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Artist::class, inversedBy="performances")
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="Performance")
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity=PerformanceDate::class, mappedBy="performance")
     */
    private $performanceDates;

    public function __construct()
    {
        $this->artist = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->performanceDates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?CategoryPerf
    {
        return $this->category;
    }

    public function setCategory(?CategoryPerf $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getArtist(): Collection
    {
        return $this->artist;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artist->contains($artist)) {
            $this->artist[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        if ($this->artist->contains($artist)) {
            $this->artist->removeElement($artist);
        }

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setPerformance($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getPerformance() === $this) {
                $ticket->setPerformance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PerformanceDate[]
     */
    public function getPerformanceDates(): Collection
    {
        return $this->performanceDates;
    }

    public function addPerformanceDate(PerformanceDate $performanceDate): self
    {
        if (!$this->performanceDates->contains($performanceDate)) {
            $this->performanceDates[] = $performanceDate;
            $performanceDate->setPerformance($this);
        }

        return $this;
    }

    public function removePerformanceDate(PerformanceDate $performanceDate): self
    {
        if ($this->performanceDates->contains($performanceDate)) {
            $this->performanceDates->removeElement($performanceDate);
            // set the owning side to null (unless already changed)
            if ($performanceDate->getPerformance() === $this) {
                $performanceDate->setPerformance(null);
            }
        }

        return $this;
    }
}
