<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Connect;
use PDO;
use PDOException;

class Product extends Model
{
    protected $id;
    protected $idCategory;
    protected $name;
    protected $price;
    protected $errorMessage;

    public function __construct(
        int $id = null,
        int $idCategory = null,
        string $name = null,
        float $price = null
    ) {
        $this->table = "products";
        $this->id = $id;
        $this->idCategory = $idCategory;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): ?int 
    { 
        return $this->id; 
    }
    public function setId(?int $id): void 
    { 
        $this->id = $id; 
    }

    public function getIdCategory(): ?int 
    { 
        return $this->idCategory; 
    }

    public function setIdCategory(?int $idCategory): void 
    { 
        $this->idCategory = $idCategory; 
    }

    public function getName(): ?string 
    { 
        return $this->name; 
    }
    public function setName(?string $name): void 
    { 
        $this->name = $name; 
    }

    public function getPrice(): ?float 
    { 
        return $this->price; 
    }
    public function setPrice(?float $price): void 
    { 
        $this->price = $price; 
    }

    public function getErrorMessage(): ?string 
    { 
        return $this->errorMessage; 
    }

    public function insert(): bool
    {
        try {
            $sql = "INSERT INTO {$this->table} (idCategory, name, price) VALUES (:idCategory, :name, :price)";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":idCategory", $this->idCategory);
            $stmt->bindValue(":name", $this->name);
            $stmt->bindValue(":price", $this->price);
            $stmt->execute();

            $this->id = Connect::getInstance()->lastInsertId();
            return true;
        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function update(): bool
    {
        try {
            $sql = "UPDATE {$this->table} SET idCategory = :idCategory, name = :name, price = :price WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":idCategory", $this->idCategory);
            $stmt->bindValue(":name", $this->name);
            $stmt->bindValue(":price", $this->price);
            $stmt->bindValue(":id", $this->id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function delete(): bool
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":id", $this->id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function findById(int $id): bool
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $data["id"];
                $this->idCategory = $data["idCategory"];
                $this->name = $data["name"];
                $this->price = $data["price"];
                return true;
            }

            return false;
        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function findAll(): array
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = Connect::getInstance()->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return [];
        }
    }
}