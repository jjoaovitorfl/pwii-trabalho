<?php

namespace Source\WebService;

use Source\Models\Address;
use Source\Support\JwtService;

class Addresses extends Api
{
    public function listByUser(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID do usuário inválido", "error")->back();
            return;
        }

        $address = new Address();
        $result = $address->findByUser($data["id"]);

        $this->call(200, "success", "Endereços carregados", "success")
            ->back($result);
    }

    public function createAddress(): void
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

        if (empty($data["idUser"]) || empty($data["street"]) || empty($data["city"])) {
            $this->call(400, "bad_request", "Campos obrigatórios não preenchidos", "error")->back();
            return;
        }

        $address = new Address(
            null,
            $data["idUser"],
            $data["street"],
            $data["number"] ?? "",
            $data["neighborhood"] ?? "",
            $data["city"],
            $data["state"] ?? "",
            $data["postalCode"] ?? "",
            $data["complement"] ?? ""
        );

        if (!$address->insert()) {
            $this->call(500, "internal_server_error", $address->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(201, "created", "Endereço cadastrado com sucesso", "success")
            ->back([
                "idUser" => $address->getIdUser(),
                "street" => $address->getStreet(),
                "city" => $address->getCity()
            ]);
    }

    public function updateAddress(array $data): void
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

        $address = new Address();
        if (!$address->findById($data["id"])) {
            $this->call(404, "not_found", "Endereço não encontrado", "error")->back();
            return;
        }

        $address->setStreet($data["street"] ?? $address->getStreet());
        $address->setNumber($data["number"] ?? $address->getNumber());
        $address->setNeighborhood($data["neighborhood"] ?? $address->getNeighborhood());
        $address->setCity($data["city"] ?? $address->getCity());
        $address->setState($data["state"] ?? $address->getState());
        $address->setPostalCode($data["postalCode"] ?? $address->getPostalCode());
        $address->setComplement($data["complement"] ?? $address->getComplement());

        if (!$address->update()) {
            $this->call(500, "internal_server_error", $address->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Endereço atualizado com sucesso", "success")
            ->back([
                "id" => $address->getId(),
                "city" => $address->getCity()
            ]);
    }

    public function deleteAddress(array $data): void
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

        $address = new Address();
        if (!$address->findById($data["id"])) {
            $this->call(404, "not_found", "Endereço não encontrado", "error")->back();
            return;
        }

        if (!$address->delete()) {
            $this->call(500, "internal_server_error", $address->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Endereço deletado com sucesso", "success")->back();
    }
}