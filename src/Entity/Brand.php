<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Car::class)]
    private Collection $cars;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Model::class)]
    private Collection $Model;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->Model = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): static
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setBrand($this);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getBrand() === $this) {
                $car->setBrand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Model>
     */
    public function getModel(): Collection
    {
        return $this->Model;
    }

    public function addModel(Model $model): static
    {
        if (!$this->Model->contains($model)) {
            $this->Model->add($model);
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): static
    {
        if ($this->Model->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name; // ou $this->modelName;
    }
}
