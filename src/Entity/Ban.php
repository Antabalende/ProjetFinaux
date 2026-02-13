<?php

namespace App\Entity;

use App\Repository\BanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BanRepository::class)]
class Ban
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $userCible = null;

    #[ORM\Column(length: 255)]
    private ?string $Raison = null;

    #[ORM\Column]
    private ?\DateTime $dateFin = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserCible(): ?string
    {
        return $this->userCible;
    }

    public function setUserCible(string $userCible): static
    {
        $this->userCible = $userCible;

        return $this;
    }

    public function getRaison(): ?string
    {
        return $this->Raison;
    }

    public function setRaison(string $Raison): static
    {
        $this->Raison = $Raison;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }
}
