<?php

namespace Source\WebService;

use Source\Models\MarketSchedule;
use Source\Support\JwtService;

class MarketSchedules extends Api
{
    public function listByMarket(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID da feira inválido", "error")->back();
            return;
        }

        $schedule = new MarketSchedule();
        $result = $schedule->findByMarket($data["id"]);

        $this->call(200, "success", "Horários da feira carregados", "success")->back($result);
    }

    public function createSchedule(): void
    {
        $headers = getallheaders();
        $authHeader = $headers["Authorization"] ?? "";

        if (!str_starts_with($authHeader, "Bearer ")) {
            $this->call(401, "unauthorized", "Token ausente ou mal formatado", "error")->back();
            return;
        }

        $token = trim(str_replace("Bearer", "", $authHeader));
        $jwt = (new JwtService())->validar($token);

        if (!$jwt) {
            $this->call(401, "unauthorized", "Token inválido ou expirado", "error")->back();
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            empty($data["idMarket"]) ||
            empty($data["dayOfWeek"]) ||
            empty($data["openTime"]) ||
            empty($data["closeTime"])
        ) {
            $this->call(400, "bad_request", "Todos os campos são obrigatórios", "error")->back();
            return;
        }

        $schedule = new MarketSchedule(
            null,
            $data["idMarket"],
            $data["dayOfWeek"],
            $data["openTime"],
            $data["closeTime"]
        );

        if (!$schedule->insert()) {
            $this->call(500, "internal_server_error", $schedule->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(201, "created", "Horário cadastrado com sucesso", "success")
            ->back([
                "idMarket" => $schedule->getIdMarket(),
                "dayOfWeek" => $schedule->getDayOfWeek(),
                "openTime" => $schedule->getOpenTime(),
                "closeTime" => $schedule->getCloseTime()
            ]);
    }

    public function updateSchedule(array $data): void
    {
        $headers = getallheaders();
        $authHeader = $headers["Authorization"] ?? "";

        if (!str_starts_with($authHeader, "Bearer ")) {
            $this->call(401, "unauthorized", "Token ausente ou mal formatado", "error")->back();
            return;
        }

        $token = trim(str_replace("Bearer", "", $authHeader));
        $jwt = (new JwtService())->validar($token);

        if (!$jwt) {
            $this->call(401, "unauthorized", "Token inválido ou expirado", "error")->back();
            return;
        }

        $id = $data["id"] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        $data["id"] = $id;

        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        $schedule = new MarketSchedule();
        if (!$schedule->findById($data["id"])) {
            $this->call(404, "not_found", "Horário não encontrado", "error")->back();
            return;
        }

        $schedule->setDayOfWeek($data["dayOfWeek"] ?? $schedule->getDayOfWeek());
        $schedule->setOpenTime($data["openTime"] ?? $schedule->getOpenTime());
        $schedule->setCloseTime($data["closeTime"] ?? $schedule->getCloseTime());

        if (!$schedule->update()) {
            $this->call(500, "internal_server_error", $schedule->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Horário atualizado com sucesso", "success")->back([
            "id" => $schedule->getId(),
            "dayOfWeek" => $schedule->getDayOfWeek()
        ]);
    }

    public function deleteSchedule(array $data): void
    {
        $headers = getallheaders();
        $authHeader = $headers["Authorization"] ?? "";

        if (!str_starts_with($authHeader, "Bearer ")) {
            $this->call(401, "unauthorized", "Token ausente ou mal formatado", "error")->back();
            return;
        }

        $token = trim(str_replace("Bearer", "", $authHeader));
        $jwt = (new JwtService())->validar($token);

        if (!$jwt) {
            $this->call(401, "unauthorized", "Token inválido ou expirado", "error")->back();
            return;
        }

        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        $schedule = new MarketSchedule();
        if (!$schedule->findById($data["id"])) {
            $this->call(404, "not_found", "Horário não encontrado", "error")->back();
            return;
        }

        if (!$schedule->delete()) {
            $this->call(500, "internal_server_error", $schedule->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Horário deletado com sucesso", "success")->back();
    }
}