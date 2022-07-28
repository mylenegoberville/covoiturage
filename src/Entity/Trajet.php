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

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'integer')]
    private $place;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $escale;

    #[ORM\ManyToMany(targetEntity: Transporter::class, mappedBy: 'idT')]
    private $transporters;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'trajets')]
    private $user;

    #[ORM\ManyToOne(targetEntity: Voiture::class, inversedBy: 'trajets')]
    private $voiture;

    public function __construct()
    {
        $this->transporters = new ArrayCollection();
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


    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVoiture(): ?voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }
}
