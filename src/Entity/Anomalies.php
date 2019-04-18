<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnomaliesRepository")
 */
class Anomalies
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
    private $anomalie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_anomalie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnomaliesType", inversedBy="anomalies")
     */
    private $type_anomalie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Controles", mappedBy="anomalies_collections")
     */
    private $controles;

    public function __construct()
    {
        $this->controles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnomalie(): ?string
    {
        return $this->anomalie;
    }

    public function setAnomalie(string $anomalie): self
    {
        $this->anomalie = $anomalie;

        return $this;
    }

    public function getCodeAnomalie(): ?string
    {
        return strtoupper($this->code_anomalie);
    }

    public function setCodeAnomalie(string $code_anomalie): self
    {
        $this->code_anomalie = strtoupper($code_anomalie);

        return $this;
    }

    public function getTypeAnomalie(): ?AnomaliesType
    {
        return $this->type_anomalie;
    }

    public function setTypeAnomalie(?AnomaliesType $type_anomalie): self
    {
        $this->type_anomalie = $type_anomalie;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
        return $this->getCodeAnomalie();
    }

    /**
     * @return Collection|Controles[]
     */
    public function getControles(): Collection
    {
        return $this->controles;
    }

    public function addControle(Controles $controle): self
    {
        if (!$this->controles->contains($controle)) {
            $this->controles[] = $controle;
            $controle->addAnomaliesCollection($this);
        }

        return $this;
    }

    public function removeControle(Controles $controle): self
    {
        if ($this->controles->contains($controle)) {
            $this->controles->removeElement($controle);
            $controle->removeAnomaliesCollection($this);
        }

        return $this;
    }
}