<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Authentication\Provider\UserAuthenticationProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Serializable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *  @UniqueEntity(
 *     fields={"email"}, 
 *     message="This email already exists."
 * )
 */


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface, Serializable
{

    const ROLE = [
        0 => 'RC',
        1 => 'RA',
        3 => 'Gestionnaire',
        4 => 'ROLE_ADMIN',
        5 => 'obs'
    ];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }


    public function getRoleType(): string
    {
        return self::ROLE[$this->role];
    }
    public function getRoles()
    {
        return ['$role'];
    }


    /**
     * @return string|null the salt
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    { }

    /**
     * string to object
     * @link https://php.net/manual/em/serializable.serialize.php
     * @return string 
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            
            // see section on salt below
            // $this->salt,
        ]);
    }

    /**
     * @param string $serialized
     * @return void
     * @since 5.1.0
     */

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }
        /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="idUser")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", mappedBy="idUser")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SubCategory", mappedBy="idUser")
     */
    private $subCategories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
    }
    
     
    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addIdUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeIdUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addIdUser($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeIdUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|SubCategory[]
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(SubCategory $subCategory): self
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories[] = $subCategory;
            $subCategory->addIdUser($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): self
    {
        if ($this->subCategories->contains($subCategory)) {
            $this->subCategories->removeElement($subCategory);
            $subCategory->removeIdUser($this);
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


public function __toString()
    {
        // to show the name of the Category in the select
        return $this->username;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
