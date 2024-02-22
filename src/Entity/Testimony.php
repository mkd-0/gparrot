<?php

namespace App\Entity;

use App\Repository\TestimonyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestimonyRepository::class)]
class Testimony
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $visitorname = null;

    #[ORM\Column]
    private ?bool $isok = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getVisitorname(): ?string
    {
        return $this->visitorname;
    }

    public function setVisitorname(?string $visitorname): static
    {
        $this->visitorname = $visitorname;

        return $this;
    }

    public function isIsok(): ?bool
    {
        return $this->isok;
    }

    public function setIsok(bool $isok): static
    {
        $this->isok = $isok;

        return $this;
    }
}
