<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;
use PhpParser\Node\Expr\Cast\Double;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[Vich\Uploadable]

class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $Mileage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Power = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $Price = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $DateCirculation = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;



    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $Model = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Color $Color = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Energy $energy = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Year $Year = null;

    #[ORM\ManyToMany(targetEntity: Equipment::class, inversedBy: 'cars')]
    private Collection $Equipment;

    #[ORM\ManyToMany(targetEntity: Picture::class, inversedBy: 'cars')]
    private Collection $picture;

    public function __construct()
    {
        $this->Equipment = new ArrayCollection();
        $this->picture = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMileage(): ?int
    {
        return $this->Mileage;
    }

    public function setMileage(?int $Mileage): static
    {
        $this->Mileage = $Mileage;

        return $this;
    }

    public function getPower(): ?string
    {
        return $this->Power;
    }

    public function setPower(?string $Power): static
    {
        $this->Power = $Power;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(?int $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDateCirculation(): ?\DateTimeImmutable
    {
        return $this->DateCirculation;
    }

    public function setDateCirculation(?\DateTimeImmutable $DateCirculation): static
    {
        $this->DateCirculation = $DateCirculation;

        return $this;
    }

    /**
     * @Groups({"car"})
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }


    /**
     * @Groups({"car"})
     */
    public function getModel(): ?Model
    {
        return $this->Model;
    }

    public function setModel(?Model $Model): static
    {
        $this->Model = $Model;

        return $this;
    }


    /**
     * @Groups({"car"})
     */
    public function getColor(): ?Color
    {
        return $this->Color;
    }

    public function setColor(?Color $Color): static
    {
        $this->Color = $Color;

        return $this;
    }


    /**
     * @Groups({"car"})
     */
    public function getEnergy(): ?Energy
    {
        return $this->energy;
    }

    public function setEnergy(?Energy $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getYear(): ?Year
    {
        return $this->Year;
    }

    public function setYear(?Year $Year): static
    {
        $this->Year = $Year;

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->Equipment;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->Equipment->contains($equipment)) {
            $this->Equipment->add($equipment);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        $this->Equipment->removeElement($equipment);

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->picture->contains($picture)) {
            $this->picture->add($picture);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        $this->picture->removeElement($picture);

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;


        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
}
