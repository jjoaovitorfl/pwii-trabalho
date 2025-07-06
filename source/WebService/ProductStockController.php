<?php

namespace Source\WebService;

use Source\Models\ProductStock;
use Source\Support\JwtService;

class ProductStockController extends Api
{
    public function getStockByProduct(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID do produto inválido", "error")->back();
            return;
        }

        $stock = new \Source\Models\ProductStock();
        if (!$stock->findByProduct($data["id"])) {
            $this->call(404, "not_found", "Estoque não encontrado para o produto", "error")->back();
            return;
        }

        $this->call(200, "success", "Estoque localizado", "success")
            ->back([
                "idProduct" => $stock->getIdProduct(),
                "quantityAvailable" => $stock->getQuantityAvailable(),
                "updatedAt" => $stock->getUpdatedAt()
            ]);
    }

    public function updateStock(array $data): void
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
            $this->call(400, "bad_request", "ID do produto inválido", "error")->back();
            return;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input["quantityAvailable"])) {
            $this->call(400, "bad_request", "Quantidade não informada", "error")->back();
            return;
        }

        $stock = new \Source\Models\ProductStock();
        if (!$stock->findByProduct($data["id"])) {
            $this->call(404, "not_found", "Estoque não encontrado", "error")->back();
            return;
        }

        $stock->setQuantityAvailable($input["quantityAvailable"]);

        if (!$stock->update()) {
            $this->call(500, "internal_server_error", $stock->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Estoque atualizado com sucesso", "success")->back([
            "idProduct" => $stock->getIdProduct(),
            "quantityAvailable" => $stock->getQuantityAvailable()
        ]);
    }
}