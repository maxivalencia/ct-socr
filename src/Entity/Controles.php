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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Immatriculation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisations", inversedBy="controles")
     */
    private $usages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $anomalies;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $papiers;

    /**
     * @ORM\Column(type="date", nullable=true)
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
     * @ORM\JoinTable(name="thread_ajouteur")
     */
    private $ajouteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="controlesretire")
     * @ORM\JoinTable(name="thread_retireur")
     */
    private $retireur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Anomalies", inversedBy="controles", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="thread_anomalies")
     */
    private $anomalies_collections;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Papiers", inversedBy="controles", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="thread_papiers")
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
     * @ORM\JoinTable(name="thread_anom")
     */
    private $anom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Papiers", inversedBy="controles1")
     * @ORM\JoinTable(name="thread_pap")
     */
    private $pap;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mise_en_fourriere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_chauffeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact_chauffeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $feuille_de_controle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_de_controle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time_created_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_debut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="controles")
     */
    private $verificateur_contre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="controle")
     */
    private $photos;

    public function __construct()
    {
        $this->anomalies_collections = new ArrayCollection();
        $this->papiers_collection = new ArrayCollection();
        $this->anom = new ArrayCollection();
        $this->pap = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->photos = new ArrayCollection();
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

    public function getMiseEnFourriere(): ?bool
    {
        return $this->mise_en_fourriere;
    }

    public function setMiseEnFourriere(bool $mise_en_fourriere): self
    {
        $this->mise_en_fourriere = $mise_en_fourriere;

        return $this;
    }

    public function getVerificateurContre(): ?User
    {
        return $this->verificateur_contre;
    }

    public function setVerificateurContre(?User $verificateur_contre): self
    {
        $this->verificateur_contre = $verificateur_contre;

        return $this;
    }

    public function getTimeCreatedAt(): ?\DateTimeInterface
    {
        return $this->time_created_at;
    }

    public function setTimeCreatedAt(?\DateTimeInterface $time_created_at): self
    {
        $this->time_created_at = $time_created_at;

        return $this;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function getNomChauffeur(): ?string
    {
        return $this->nom_chauffeur;
    }

    public function setNomChauffeur(string $nom_chauffeur): self
    {
        $this->nom_chauffeur = $nom_chauffeur;

        return $this;
    }

    public function getContactChauffeur(): ?string
    {
        return $this->contact_chauffeur;
    }

    public function setContactChauffeur(string $contact_chauffeur): self
    {
        $this->contact_chauffeur = $contact_chauffeur;

        return $this;
    }

    public function getFeuilleDeControle(): ?string
    {
        return $this->feuille_de_controle;
    }

    public function setFeuilleDeControle(string $feuille_de_controle): self
    {
        $this->feuille_de_controle = $feuille_de_controle;

        return $this;
    }

    public function getLieuDeControle(): ?string
    {
        return $this->lieu_de_controle;
    }

    public function setLieuDeControle(string $lieu_de_controle): self
    {
        $this->lieu_de_controle = $lieu_de_controle;

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

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setControle($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getControle() === $this) {
                $photo->setControle(null);
            }
        }

        return $this;
    }
}
