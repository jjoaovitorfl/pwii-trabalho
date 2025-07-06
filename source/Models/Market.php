<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\Connect;
use PDO;
use PDOException;

class Market extends Model
{
    private $id;
    private $name;
    private $address;
    private $participants;
    private $durationTime;
    protected $errorMessage;

    public function __construct(
        int $id = null,
        string $name = null,
        string $address = null,
        string $participants = null,
        string $durationTime = null
    ) {
        $this->table = "markets";
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->participants = $participants;
        $this->durationTime = $durationTime;
    }

    public function getId(): ?int 
    { 
        return $this->id; 
    }
    public function setId(?int $id): void 
    { 
        $this->id = $id; 
    }

    public function getName(): ?string 
    { 
        return $this->name; 
    }
    public function setName(?string $name): void 
    { 
        $this->name = $name; 
    }

    public function getAddress(): ?string 
    { 
        return $this->address; 
    }
    public function setAddress(?string $address): void 
    { 
        $this->address = $address; 
    }

    public function getParticipants(): ?string 
    { 
        return $this->participants; 
    }
    public function setParticipants(?string $participants): void 
    { 
        $this->participants = $participants; 
    }

    public function getDurationTime(): ?string 
    { 
        return $this->durationTime; 
    }
    public function setDurationTime(?string $durationTime): void 
    { 
        $this->durationTime = $durationTime; 
    }

    public function getErrorMessage(): ?string 
    { 
        return $this->errorMessage; 
    }

    public function insert(): bool
    {
        try {
            $sql = "INSERT INTO {$this->table} (name, address, participants, durationTime) 
                    VALUES (:name, :address, :participants, :durationTime)";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":name", $this->name);
            $stmt->bindValue(":address", $this->address);
            $stmt->bindValue(":participants", $this->participants);
            $stmt->bindValue(":durationTime", $this->durationTime);
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
            $sql = "UPDATE {$this->table} 
                    SET name = :name, address = :address, participants = :participants, durationTime = :durationTime 
                    WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":name", $this->name);
            $stmt->bindValue(":address", $this->address);
            $stmt->bindValue(":participants", $this->participants);
            $stmt->bindValue(":durationTime", $this->durationTime);
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
                $this->name = $data["name"];
                $this->address = $data["address"];
                $this->participants = $data["participants"];
                $this->durationTime = $data["durationTime"];
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
}