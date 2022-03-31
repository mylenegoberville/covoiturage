<?php

namespace App\Entity;

use App\Repository\TransporterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransporterRepository::class)]
class Transporter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Trajet::class, inversedBy: 'transporters')]
    private $idT;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'transporters')]
    private $IdU;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    public function __construct()
    {
        $this->idT = new ArrayCollection();
        $this->IdU = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getIdT(): Collection
    {
        return $this->idT;
    }

    public function addIdT(Trajet $idT): self
    {
        if (!$this->idT->contains($idT)) {
            $this->idT[] = $idT;
        }

        return $this;
    }

    public function removeIdT(Trajet $idT): self
    {
        $this->idT->removeElement($idT);

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getIdU(): Collection
    {
        return $this->IdU;
    }

    public function addIdU(user $idU): self
    {
        if (!$this->IdU->contains($idU)) {
            $this->IdU[] = $idU;
        }

        return $this;
    }

    public function removeIdU(user $idU): self
    {
        $this->IdU->removeElement($idU);

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
