<?php

namespace App\Input;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class CategoryInput
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var datetime
     */
    private $created_at;

    /**
     * @var datetime
     */
    private $updated_at;

    /**
     * @var datetime
     */
    private $deleted_at;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;

    }
    public function getCreatedAt(): String
    {

        return $this->created_at ? $this->created_at->format("Y-m-d H:i"): false;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?String
    {

        return $this->updated_at ? $this->updated_at ->format("Y-m-d H:i") :NULL;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?String
    {
        return $this->deleted_at ? $this->deleted_at ->format("Y-m-d H:i") :NULL;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }
}
