<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnomaliesRepository;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ControlesRepository")
 */
class Controles
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
    private $Immatriculation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisations", inversedBy="controles")
     */
    private $usages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Enregistrement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="controles")
     */
    private $verificateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Centres", inversedBy="controles")
     */
    private $centre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    
    /**
     * @ORM\Column(type="text")
     */
    private $anomalies;

    /**
     * @ORM\Column(type="text")
     */
    private $papiers;

    /**
     * @ORM\Column(type="date")
     */
    private $date_expiration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $papiers_retirers;

    /**
     * @ORM\Column(type="date")
     */
    private $CreatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="controleajout")
     */
    private $ajouteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="controlesretire")
     */
    private $retireur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Anomalies", inversedBy="controles", cascade={"persist", "remove"})
     */
    private $anomalies_collections;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Papiers", inversedBy="controles", cascade={"persist", "remove"})
     */
    private $papiers_collection;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_retrait;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heure_retrait;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Anomalies", inversedBy="controles1")
     */
    private $anom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Papiers", inversedBy="controles1")
     */
    private $pap;

    public function __construct()
    {
        $this->anomalies_collections = new ArrayCollection();
        $this->papiers_collection = new ArrayCollection();
        $this->anom = new ArrayCollection();
        $this->pap = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return strtoupper($this->Immatriculation);
    }

    public function setImmatriculation(string $Immatriculation): self
    {
        $this->Immatriculation = strtoupper($Immatriculation);

        return $this;
    }

    public function getUsages(): ?Utilisations
    {
        return $this->usages;
    }

    public function setUsages(?Utilisations $usages): self
    {
        $this->usages = $usages;

        return $this;
    }

    public function getEnregistrement(): ?string
    {
        return strtoupper($this->Enregistrement);
    }

    public function setEnregistrement(string $Enregistrement): self
    {
        $this->Enregistrement = strtoupper($Enregistrement);

        return $this;
    }

    public function getVerificateur(): ?User
    {
        return $this->verificateur;
    }

    public function setVerificateur(?User $verificateur): self
    {
        $this->verificateur = $verificateur;

        return $this;
    }

    public function getCentre(): ?Centres
    {
        return $this->centre;
    }

    public function setCentre(?Centres $centre): self
    {
        $this->centre = $centre;

        return $this;
    }

    public function getProprietaire(): ?string
    {
        return $this->proprietaire;
    }

    public function setProprietaire(string $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAnomalies(): ?string
    {
        return $this->anomalies;
    }

    public function setAnomalies(string $anomalies): self
    {
        $this->anomalies = $anomalies;

        return $this;
    }

    public function getPapiers(): ?string
    {
        return $this->papiers;
    }

    public function setPapiers(string $papiers): self
    {
        $this->papiers = $papiers;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeInterface $date_expiration): self
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }

    public function getPapiersRetirers(): ?bool
    {
        return $this->papiers_retirers;
    }

    public function setPapiersRetirers(bool $papiers_retirers): self
    {
        $this->papiers_retirers = $papiers_retirers;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getAjouteur(): ?User
    {
        return $this->ajouteur;
    }

    public function setAjouteur(?User $ajouteur): self
    {
        $this->ajouteur = $ajouteur;

        return $this;
    }

    public function getRetireur(): ?User
    {
        return $this->retireur;
    }

    public function setRetireur(?User $retireur): self
    {
        $this->retireur = $retireur;

        return $this;
    }

    /**
     * @return Collection|Anomalies[]
     */
    public function getAnomaliesCollections(): Collection
    {
        return $this->anomalies_collections;
    }
    
    public function setAnomaliesCollections(Anomalies $anomaliesCollection):self
    {        
        if (!$this->anomalies_collections->contains($anomaliesCollection)) {
            $this->anomalies_collections[] = $anomaliesCollection;
        }

        return $this;
    }

    public function addAnomaliesCollection(Anomalies $anomaliesCollection): self
    {
        if (!$this->anomalies_collections->contains($anomaliesCollection)) {
            $this->anomalies_collections[] = $anomaliesCollection;
        }

        return $this;
    }

    public function removeAnomaliesCollection(Anomalies $anomaliesCollection): self
    {
        if ($this->anomalies_collections->contains($anomaliesCollection)) {
            $this->anomalies_collections->removeElement($anomaliesCollection);
        }

        return $this;
    }

    /**
     * @return Collection|Papiers[]
     */
    public function getPapiersCollection(): Collection
    {
        return $this->papiers_collection;
    }

    public function setPapiersCollection(Papiers $papiersCollection):self
    {        
        if (!$this->papiers_collection->contains($papiersCollection)) {
            $this->papiers_collection[] = $papiersCollection;
        }

        return $this;
    }

    public function addPapiersCollection(Papiers $papiersCollection): self
    {
        if (!$this->papiers_collection->contains($papiersCollection)) {
            $this->papiers_collection[] = $papiersCollection;
        }

        return $this;
    }

    public function removePapiersCollection(Papiers $papiersCollection): self
    {
        if ($this->papiers_collection->contains($papiersCollection)) {
            $this->papiers_collection->removeElement($papiersCollection);
        }

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->date_retrait;
    }

    public function setDateRetrait(?\DateTimeInterface $date_retrait): self
    {
        $this->date_retrait = $date_retrait;

        return $this;
    }

    public function getHeureRetrait(): ?\DateTimeInterface
    {
        return $this->heure_retrait;
    }

    public function setHeureRetrait(?\DateTimeInterface $heure_retrait): self
    {
        $this->heure_retrait = $heure_retrait;

        return $this;
    }

    /**
     * @return Collection|Anomalies[]
     */
    public function getAnom(): Collection
    {
        return $this->anom;
    }

    public function addAnom(Anomalies $anom): self
    {
        if (!$this->anom->contains($anom)) {
            $this->anom[] = $anom;
        }

        return $this;
    }

    public function removeAnom(Anomalies $anom): self
    {
        if ($this->anom->contains($anom)) {
            $this->anom->removeElement($anom);
        }

        return $this;
    }

    /**
     * @return Collection|Papiers[]
     */
    public function getPap(): Collection
    {
        return $this->pap;
    }

    public function addPap(Papiers $pap): self
    {
        if (!$this->pap->contains($pap)) {
            $this->pap[] = $pap;
        }

        return $this;
    }

    public function removePap(Papiers $pap): self
    {
        if ($this->pap->contains($pap)) {
            $this->pap->removeElement($pap);
        }

        return $this;
    }
}
