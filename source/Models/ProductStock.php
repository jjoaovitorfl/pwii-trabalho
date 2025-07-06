<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\Core\Model;

class ProductStock extends Model
{
    protected $id;
    protected $idProduct;
    protected $quantityAvailable;
    protected $updatedAt;

    public function __construct(
        int $id = null,
        int $idProduct = null,
        int $quantityAvailable = null,
        string $updatedAt = null
    ) {
        $this->table = "productStock";
        $this->id = $id;
        $this->idProduct = $idProduct;
        $this->quantityAvailable = $quantityAvailable;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function setIdProduct(?int $idProduct): void
    {
        $this->idProduct = $idProduct;
    }

    public function getQuantityAvailable(): ?int
    {
        return $this->quantityAvailable;
    }

    public function setQuantityAvailable(?int $quantityAvailable): void
    {
        $this->quantityAvailable = $quantityAvailable;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function findByProduct(int $idProduct): bool
    {
        $sql = "SELECT * FROM {$this->table} WHERE idProduct = :idProduct";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->bindValue(":idProduct", $idProduct);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false;
        }

        $stock = $stmt->fetch();
        $this->id = $stock->id;
        $this->idProduct = $stock->idProduct;
        $this->quantityAvailable = $stock->quantityAvailable;
        $this->updatedAt = $stock->updatedAt;

        return true;
    }

    public function update(): bool
    {
        try {
            $sql = "UPDATE {$this->table} SET quantityAvailable = :quantityAvailable WHERE idProduct = :idProduct";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":quantityAvailable", $this->quantityAvailable);
            $stmt->bindValue(":idProduct", $this->idProduct);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }
}