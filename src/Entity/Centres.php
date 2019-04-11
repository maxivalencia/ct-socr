<?php

namespace App\Entity;

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
        return $this->centre;
    }

    public function setCentre(string $centre): self
    {
        $this->centre = $centre;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
}
