<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PapiersRepository")
 */
class Papiers
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
    private $papier;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Controles", mappedBy="papiers_collection")
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

    public function getPapier(): ?string
    {
        return strtoupper($this->papier);
    }

    public function setPapier(string $papier): self
    {
        $this->papier = strtoupper($papier);

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
        return $this->getPapier();
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
            $controle->addPapiersCollection($this);
        }

        return $this;
    }

    public function removeControle(Controles $controle): self
    {
        if ($this->controles->contains($controle)) {
            $this->controles->removeElement($controle);
            $controle->removePapiersCollection($this);
        }

        return $this;
    }
}
