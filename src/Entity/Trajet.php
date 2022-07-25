<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $depart;

    #[ORM\Column(type: 'string', length: 255)]
    private $arrivee;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'time')]
    private $heure;

    #[ORM\Column(type: 'integer')]
    private $place;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $escale;

    #[ORM\ManyToMany(targetEntity: Transporter::class, mappedBy: 'idT')]
    private $transporters;

    #[ORM\OneToMany(mappedBy: 'trajet', targetEntity: Voiture::class)]
    private $voiture;

    public function __construct()
    {
        $this->transporters = new ArrayCollection();
        $this->voiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrivee(): ?string
    {
        return $this->arrivee;
    }

    public function setArrivee(string $arrivee): self
    {
        $this->arrivee = $arrivee;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getEscale(): ?string
    {
        return $this->escale;
    }

    public function setEscale(?string $escale): self
    {
        $this->escale = $escale;

        return $this;
    }

    /**
     * @return Collection<int, Transporter>
     */
    public function getTransporters(): Collection
    {
        return $this->transporters;
    }

    public function addTransporter(Transporter $transporter): self
    {
        if (!$this->transporters->contains($transporter)) {
            $this->transporters[] = $transporter;
            $transporter->addIdT($this);
        }

        return $this;
    }

    public function removeTransporter(Transporter $transporter): self
    {
        if ($this->transporters->removeElement($transporter)) {
            $transporter->removeIdT($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, voiture>
     */
    public function getVoiture(): Collection
    {
        return $this->voiture;
    }

    public function addVoiture(voiture $voiture): self
    {
        if (!$this->voiture->contains($voiture)) {
            $this->voiture[] = $voiture;
            $voiture->setTrajet($this);
        }

        return $this;
    }

    public function removeVoiture(voiture $voiture): self
    {
        if ($this->voiture->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getTrajet() === $this) {
                $voiture->setTrajet(null);
            }
        }

        return $this;
    }
}
