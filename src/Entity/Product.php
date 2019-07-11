<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @UniqueEntity(
 *     fields={"name"}, 
 *     message="This product already exists."
 * )
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $unit;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $package;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\Type(
     *     type="numeric",
     *     message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $stock;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\Type(
     *     type="numeric",
     *     message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $price;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dueDate;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier", inversedBy="products")
     */
    private $idSupplier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubCategory", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idSubCategory;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="products")
     */
    private $idUser;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bio;

    public function __construct()
    {
        $this->idUser = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getPackage(): ?string
    {
        return $this->package;
    }

    public function setPackage(?string $package): self
    {
        $this->package = $package;

        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getIdSupplier(): ?Supplier
    {
        return $this->idSupplier;
    }

    public function setIdSupplier(?Supplier $idSupplier): self
    {
        $this->idSupplier = $idSupplier;

        return $this;
    }

    public function getIdSubCategory(): ?SubCategory
    {
        return $this->idSubCategory;
    }

    public function setIdSubCategory(?SubCategory $idSubCategory): self
    {
        $this->idSubCategory = $idSubCategory;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        if ($this->idUser->contains($idUser)) {
            $this->idUser->removeElement($idUser);
        }

        return $this;
    }

    public function getBio(): ?bool
    {
        return $this->bio;
    }

    public function setBio(?bool $bio): self
    {
        $this->bio = $bio;

        return $this;
    }
}
