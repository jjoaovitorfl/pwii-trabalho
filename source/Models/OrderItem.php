<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\Core\Model;

class OrderItem extends Model
{
    protected ?int $id;
    protected int $idOrder;
    protected int $idProduct;
    protected int $quantity;
    protected float $unitPrice;

    public function __construct(
        int $id = null,
        int $idOrder = null,
        int $idProduct = null,
        int $quantity = null,
        float $unitPrice = null
    ) {
        $this->table = "orderItems";
        $this->id = $id;
        $this->idOrder = $idOrder;
        $this->idProduct = $idProduct;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdOrder(): int
    {
        return $this->idOrder;
    }

    public function setIdOrder(int $idOrder): void
    {
        $this->idOrder = $idOrder;
    }

    public function getIdProduct(): int
    {
        return $this->idProduct;
    }

    public function setIdProduct(int $idProduct): void
    {
        $this->idProduct = $idProduct;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }
}