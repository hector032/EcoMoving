<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Packs", inversedBy="order")
     */
    private $packs;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="order")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="order")
     */
    private $product;

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

    public function getPacks(): Packs
    {
        return $this->packs;
    }

    public function setPacks(Packs $packs): self
    {
        $this->packs = $packs;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCreatedAt(): ?String
    {
        return $this->created_at ? $this->created_at->format("Y-m-d H:i") : NULL;
    }

    public function setCreatedAt(\DateTime $created_at): Order
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?String
    {
        return $this->updated_at ? $this->updated_at->format("Y-m-d H:i") : NULL;
    }

    public function setUpdatedAt(\DateTime $updated_at): Order
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?String
    {
        return $this->deleted_at ? $this->deleted_at->format("Y-m-d H:i") : NULL;
    }

    public function setDeletedAt(\DateTime $deleted_at): Order
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
