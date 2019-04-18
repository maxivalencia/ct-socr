<?php

namespace App\Entity;

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
}
