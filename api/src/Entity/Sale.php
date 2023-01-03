<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\SaleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
#[ApiResource()]
#[Get()]
#[GetCollection()]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[NotNull]
    private ?\DateTimeInterface $soldAt = null;

    #[ORM\Column(length: 255)]
    #[NotNull]
    private ?string $codeDepartement = null;

    #[ORM\Column]
    #[NotNull]
    #[Positive]
    private ?int $surface = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 2)]
    #[NotNull]
    #[Regex("\d+(.\d{1,2})")]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoldAt(): ?\DateTimeInterface
    {
        return $this->soldAt;
    }

    public function setSoldAt(\DateTimeInterface $soldAt): self
    {
        $this->soldAt = $soldAt;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(string $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
