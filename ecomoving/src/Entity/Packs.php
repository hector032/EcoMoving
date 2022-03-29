<?php

namespace App\Entity;

use App\Repository\PacksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PacksRepository::class)
 */
class Packs
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
     * @ORM\Column(type="float")
     */
    private $duration;


    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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
     * @ORM\Column(type="boolean")
     */
    private $status;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?String
    {

        return $this->created_at ? $this->created_at->format("Y-m-d H:i") : NULL;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): Packs
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?String
    {

        return $this->updated_at ? $this->updated_at ->format("Y-m-d H:i") :NULL;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): Packs
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?String
    {
        return $this->deleted_at ? $this->deleted_at ->format("Y-m-d H:i") :NULL;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): Packs
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
