<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\Core\Model;

class Order extends Model
{
    protected $id;
    protected $idUser;
    protected $idMarket;
    protected $totalValue;
    protected $status;
    protected $createdAt;

    public function __construct(
        int $id = null,
        int $idUser = null,
        int $idMarket = null,
        float $totalValue = null,
        string $status = "pendente",
        string $createdAt = null
    ) {
        $this->table = "orders";
        $this->id = $id;
        $this->idUser = $idUser;
        $this->idMarket = $idMarket;
        $this->totalValue = $totalValue;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getIdMarket(): ?int
    {
        return $this->idMarket;
    }

    public function setIdMarket(?int $idMarket): void
    {
        $this->idMarket = $idMarket;
    }

    public function getTotalValue(): ?float
    {
        return $this->totalValue;
    }

    public function setTotalValue(?float $totalValue): void
    {
        $this->totalValue = $totalValue;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function insert(): bool
    {
        if (!parent::insert()) {
            $this->errorMessage = "Erro ao inserir o pedido: {$this->getErrorMessage()}";
            return false;
        }

        return true;
    }

    public function findById(int $id): bool
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false;
        }

        $order = $stmt->fetch();

        $this->id = $order->id;
        $this->idUser = $order->idUser;
        $this->idMarket = $order->idMarket;
        $this->totalValue = $order->totalValue;
        $this->status = $order->status;
        $this->createdAt = $order->createdAt;

        return true;
    }

    public function getData(): array
    {
        return [
            "id" => $this->id,
            "idUser" => $this->idUser,
            "idMarket" => $this->idMarket,
            "totalValue" => $this->totalValue,
            "status" => $this->status,
            "createdAt" => $this->createdAt
        ];
    }

    public function delete(): bool
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":id", $this->id);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }
}