<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): Category
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?String
    {

        return $this->created_at ? $this->created_at->format("Y-m-d H:i") : NULL;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): Category
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): Category
    {
        $this->status = $status;
        return $this;

    }

    public function getUpdatedAt(): ?String
    {

        return $this->updated_at ? $this->updated_at ->format("Y-m-d H:i") :NULL;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): Category
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?String
    {
        return $this->deleted_at ? $this->deleted_at ->format("Y-m-d H:i") :NULL;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): Category
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }
}
