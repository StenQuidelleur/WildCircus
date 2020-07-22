<?php

namespace App\Entity;

use App\Repository\PerformanceDateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerformanceDateRepository::class)
 */
class PerformanceDate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Performance::class, inversedBy="performanceDates")
     */
    private $performance;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class, inversedBy="performanceDates")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerformance(): ?Performance
    {
        return $this->performance;
    }

    public function setPerformance(?Performance $performance): self
    {
        $this->performance = $performance;

        return $this;
    }

    public function getDate(): ?Date
    {
        return $this->date;
    }

    public function setDate(?Date $date): self
    {
        $this->date = $date;

        return $this;
    }
}
