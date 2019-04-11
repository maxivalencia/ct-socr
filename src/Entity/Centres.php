<?php

namespace App\Entity;

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

}
