<?php


namespace App\Input;


class OrderInput
{

    private $user_id;

    private $packs_id;

    private $product_id;

    private $status;


    public function getUserId(): int
    {
        return $this->user_id;
    }


    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }


    public function getPacksId(): int
    {
        return $this->packs_id;
    }


    public function setPacksId(int $packs_id): self
    {
        $this->packs_id = $packs_id;
        return $this;
    }


    public function getProductId(): int
    {
        return $this->product_id;
    }


    public function setProductId(int $product_id): self
    {
        $this->product_id = $product_id;
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