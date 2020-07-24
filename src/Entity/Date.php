<?php

namespace App\Entity;

use App\Repository\DateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DateRepository::class)
 */
class Date
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=PerformanceDate::class, mappedBy="date")
     */
    private $performanceDates;

    public function __construct()
    {
        $this->performanceDates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
            $performanceDate->setDate($this);
        }

        return $this;
    }

    public function removePerformanceDate(PerformanceDate $performanceDate): self
    {
        if ($this->performanceDates->contains($performanceDate)) {
            $this->performanceDates->removeElement($performanceDate);
            // set the owning side to null (unless already changed)
            if ($performanceDate->getDate() === $this) {
                $performanceDate->setDate(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDate()->format('Y-m-d');
    }
}
