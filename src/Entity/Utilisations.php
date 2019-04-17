<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisationsRepository")
 */
class Utilisations
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
    private $utilisation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Controles", mappedBy="usages")
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

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(string $utilisation): self
    {
        $this->utilisation = $utilisation;

        return $this;
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
            $controle->setUsages($this);
        }

        return $this;
    }

    public function removeControle(Controles $controle): self
    {
        if ($this->controles->contains($controle)) {
            $this->controles->removeElement($controle);
            // set the owning side to null (unless already changed)
            if ($controle->getUsages() === $this) {
                $controle->setUsages(null);
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
        return $this->getUtilisation();
    }
}
