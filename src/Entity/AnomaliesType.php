<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnomaliesTypeRepository")
 */
class AnomaliesType
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
    private $anomalieType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Anomalies", mappedBy="type_anomalie")
     */
    private $anomalies;

    public function __construct()
    {
        $this->anomalies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnomalieType(): ?string
    {
        return strtoupper($this->anomalieType);
    }

    public function setAnomalieType(string $anomalieType): self
    {
        $this->anomalieType = strtoupper($anomalieType);

        return $this;
    }

    /**
     * @return Collection|Anomalies[]
     */
    public function getAnomalies(): Collection
    {
        return $this->anomalies;
    }

    public function addAnomaly(Anomalies $anomaly): self
    {
        if (!$this->anomalies->contains($anomaly)) {
            $this->anomalies[] = $anomaly;
            $anomaly->setTypeAnomalie($this);
        }

        return $this;
    }

    public function removeAnomaly(Anomalies $anomaly): self
    {
        if ($this->anomalies->contains($anomaly)) {
            $this->anomalies->removeElement($anomaly);
            // set the owning side to null (unless already changed)
            if ($anomaly->getTypeAnomalie() === $this) {
                $anomaly->setTypeAnomalie(null);
            }
        }

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
        return $this->getAnomalieType();
    }
}
