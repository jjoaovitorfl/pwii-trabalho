<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\Core\Model;

class Address extends Model
{
    protected $id;
    protected $idUser;
    protected $street;
    protected $number;
    protected $neighborhood;
    protected $city;
    protected $state;
    protected $postalCode;
    protected $complement;

    public function __construct(
        int $id = null,
        int $idUser = null,
        string $street = null,
        string $number = null,
        string $neighborhood = null,
        string $city = null,
        string $state = null,
        string $postalCode = null,
        string $complement = null
    ) {
        $this->table = "addresses";
        $this->id = $id;
        $this->idUser = $idUser;
        $this->street = $street;
        $this->number = $number;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalCode;
        $this->complement = $complement;
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    public function getNeighborhood(): ?string
    {
        return $this->neighborhood;
    }

    public function setNeighborhood(?string $neighborhood): void
    {
        $this->neighborhood = $neighborhood;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): void
    {
        $this->complement = $complement;
    }

    public function insert(): bool
    {
        return parent::insert();
    }

    public function update(): bool
    {
        try {
            $sql = "UPDATE {$this->table} SET
                        street = :street,
                        number = :number,
                        neighborhood = :neighborhood,
                        city = :city,
                        state = :state,
                        postalCode = :postalCode,
                        complement = :complement
                    WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":street", $this->street);
            $stmt->bindValue(":number", $this->number);
            $stmt->bindValue(":neighborhood", $this->neighborhood);
            $stmt->bindValue(":city", $this->city);
            $stmt->bindValue(":state", $this->state);
            $stmt->bindValue(":postalCode", $this->postalCode);
            $stmt->bindValue(":complement", $this->complement);
            $stmt->bindValue(":id", $this->id);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
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
        } catch (\PDOException $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    public function findByUser(int $idUser): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE idUser = :idUser";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->bindValue(":idUser", $idUser);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }
}