<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\Core\Model;

class MarketSchedule extends Model
{
    protected $id;
    protected $idMarket;
    protected $dayOfWeek;
    protected $openTime;
    protected $closeTime;

    public function __construct(
        int $id = null,
        int $idMarket = null,
        string $dayOfWeek = null,
        string $openTime = null,
        string $closeTime = null
    ) {
        $this->table = "marketSchedules";
        $this->id = $id;
        $this->idMarket = $idMarket;
        $this->dayOfWeek = $dayOfWeek;
        $this->openTime = $openTime;
        $this->closeTime = $closeTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMarket(): ?int
    {
        return $this->idMarket;
    }

    public function setIdMarket(?int $idMarket): void
    {
        $this->idMarket = $idMarket;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(?string $dayOfWeek): void
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    public function getOpenTime(): ?string
    {
        return $this->openTime;
    }

    public function setOpenTime(?string $openTime): void
    {
        $this->openTime = $openTime;
    }

    public function getCloseTime(): ?string
    {
        return $this->closeTime;
    }

    public function setCloseTime(?string $closeTime): void
    {
        $this->closeTime = $closeTime;
    }

    public function findByMarket(int $idMarket): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE idMarket = :idMarket";
        $stmt = Connect::getInstance()->prepare($sql);
        $stmt->bindValue(":idMarket", $idMarket);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }

    public function update(): bool
    {
        try {
            $sql = "UPDATE {$this->table} SET
                        dayOfWeek = :dayOfWeek,
                        openTime = :openTime,
                        closeTime = :closeTime
                    WHERE id = :id";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindValue(":dayOfWeek", $this->dayOfWeek);
            $stmt->bindValue(":openTime", $this->openTime);
            $stmt->bindValue(":closeTime", $this->closeTime);
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
}