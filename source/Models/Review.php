<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\Core\Model;

class Review extends Model
{
    protected $id;
    protected $idUser;
    protected $idProduct;
    protected $idMarket;
    protected $rating;
    protected $comment;
    protected $createdAt;

    public function __construct(
        int $id = null,
        int $idUser = null,
        ?int $idProduct = null,
        ?int $idMarket = null,
        int $rating = null,
        string $comment = null,
        string $createdAt = null
    ) {
        $this->table = "reviews";
        $this->id = $id;
        $this->idUser = $idUser;
        $this->idProduct = $idProduct;
        $this->idMarket = $idMarket;
        $this->rating = $rating;
        $this->comment = $comment;
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

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function setIdProduct(?int $idProduct): void
    {
        $this->idProduct = $idProduct;
    }

    public function getIdMarket(): ?int
    {
        return $this->idMarket;
    }

    public function setIdMarket(?int $idMarket): void
    {
        $this->idMarket = $idMarket;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function insert(): bool
    {
        if ($this->rating < 1 || $this->rating > 5) {
            $this->errorMessage = "A nota deve estar entre 1 e 5";
            return false;
        }

        return parent::insert();
    }

    public function findByMarket(int $idMarket): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE idMarket = :idMarket";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->bindValue(":idMarket", $idMarket);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }

    public function findByProduct(int $idProduct): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE idProduct = :idProduct";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->bindValue(":idProduct", $idProduct);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }
}