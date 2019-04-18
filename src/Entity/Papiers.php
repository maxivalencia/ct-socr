<?php

namespace App\Entity;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPapier(): ?string
    {
        return $this->papier;
    }

    public function setPapier(string $papier): self
    {
        $this->papier = $papier;

        return $this;
    }
}
