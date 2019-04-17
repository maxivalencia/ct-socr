<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CentresRepository")
 */
class Centres
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
    private $centre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provinces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $province;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Controles", mappedBy="centre")
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

    public function getCentre(): ?string
    {
        return strtoupper($this->centre);
    }

    public function setCentre(string $centre): self
    {
        $this->centre = strtoupper($centre);

        return $this;
    }

    public function getCode(): ?string
    {
        return strtoupper($this->code);
    }

    public function setCode(string $code): self
    {
        $this->code = strtoupper($code);

        return $this;
    }

    public function getProvince(): ?Provinces
    {
        return $this->province;
    }

    public function setProvince(?Provinces $province): self
    {
        $this->province = $province;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
        return $this->getCode();
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
            $controle->setCentre($this);
        }

        return $this;
    }

    public function removeControle(Controles $controle): self
    {
        if ($this->controles->contains($controle)) {
            $this->controles->removeElement($controle);
            // set the owning side to null (unless already changed)
            if ($controle->getCentre() === $this) {
                $controle->setCentre(null);
            }
        }

        return $this;
    }

}
