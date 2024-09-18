<?php

namespace App\Entity;

use App\Repository\CryptoCurrencyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CryptoCurrencyRepository::class)]
class CryptoCurrency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 16)]
    private string $symbol;

    #[ORM\Column]
    private float $currentPrice;

    #[ORM\Column(type: 'bigint')]
    private string $totalVolume;

    #[ORM\Column]
    private float $ath;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $athDate;

    #[ORM\Column]
    private float $atl;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $atlDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): static
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    public function setCurrentPrice(float $currentPrice): static
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    public function getTotalVolume(): string
    {
        return $this->totalVolume;
    }

    public function setTotalVolume(string $totalVolume): static
    {
        $this->totalVolume = $totalVolume;

        return $this;
    }

    public function getAth(): float
    {
        return $this->ath;
    }

    public function setAth(float $ath): static
    {
        $this->ath = $ath;

        return $this;
    }

    public function getAthDate(): \DateTimeInterface
    {
        return $this->athDate;
    }

    public function setAthDate(\DateTimeInterface $athDate): static
    {
        $this->athDate = $athDate;

        return $this;
    }

    public function getAtl(): float
    {
        return $this->atl;
    }

    public function setAtl(float $atl): static
    {
        $this->atl = $atl;

        return $this;
    }

    public function getAtlDate(): \DateTimeInterface
    {
        return $this->atlDate;
    }

    public function setAtlDate(\DateTimeInterface $atlDate): static
    {
        $this->atlDate = $atlDate;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
