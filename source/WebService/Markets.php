<?php

namespace Source\WebService;

use Source\Models\Market;

class Markets extends Api
{
    public function listMarkets(): void
    {
        $markets = new Market();
        $this->call(200, "success", "Lista de feiras", "success")
            ->back($markets->findAll());
    }

    public function createMarket(array $data)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (in_array("", $data)) {
            $this->call(400, "bad_request", "Dados inválidos", "error")->back();
            return;
        }

        $market = new Market(
            null,
            $data["name"] ?? null,
            $data["address"] ?? null,
            $data["participants"] ?? null,
            $data["durationTime"] ?? null
        );

        if (!$market->insert()) {
            $this->call(500, "internal_server_error", $market->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "name" => $market->getName(),
            "address" => $market->getAddress(),
            "participants" => $market->getParticipants(),
            "durationTime" => $market->getDurationTime()
        ];

        $this->call(201, "created", "Feira criada com sucesso", "success")
            ->back($response);
    }

    public function listMarketById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        $market = new Market();
        if (!$market->findById($data["id"])) {
            $this->call(404, "not_found", "Feira não encontrada", "error")->back();
            return;
        }

        $response = [
            "name" => $market->getName(),
            "address" => $market->getAddress(),
            "participants" => $market->getParticipants(),
            "durationTime" => $market->getDurationTime()
        ];

        $this->call(200, "success", "Feira encontrada com sucesso", "success")->back($response);
    }

    public function updateMarket(array $data): void
    {
        $id = $data["id"] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        $data["id"] = $id;

        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        if (in_array("", $data)) {
            $this->call(400, "bad_request", "Dados inválidos", "error")->back();
            return;
        }

        $market = new Market();
        if (!$market->findById($data["id"])) {
            $this->call(404, "not_found", "Feira não encontrada", "error")->back();
            return;
        }

        $market->setName($data["name"] ?? $market->getName());
        $market->setAddress($data["address"] ?? $market->getAddress());
        $market->setParticipants($data["participants"] ?? $market->getParticipants());
        $market->setDurationTime($data["durationTime"] ?? $market->getDurationTime());

        if (!$market->update()) {
            $this->call(500, "internal_server_error", $market->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Feira atualizada com sucesso", "success")->back
        ([
            "name" => $market->getName(),
            "address" => $market->getAddress()
        ]);
    }

    public function deleteMarket(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        $market = new Market();
        if (!$market->findById($data["id"])) {
            $this->call(404, "not_found", "Feira não encontrada", "error")->back();
            return;
        }

        if (!$market->delete()) {
            $this->call(500, "internal_server_error", $market->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Feira deletada com sucesso", "success")->back();
    }
}