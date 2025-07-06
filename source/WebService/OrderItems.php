<?php

namespace Source\WebService;

use Source\Models\OrderItem;
use Source\Support\JwtService;

class OrderItems extends Api
{
    public function createItem(): void
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

        if (in_array("", $data) || !isset($data["idOrder"], $data["idProduct"], $data["quantity"], $data["unitPrice"])) {
            $this->call(400, "bad_request", "Dados incompletos ou inválidos", "error")->back();
            return;
        }

        $item = new OrderItem(
            null,
            $data["idOrder"],
            $data["idProduct"],
            $data["quantity"],
            $data["unitPrice"]
        );

        if (!$item->insert()) {
            $this->call(500, "internal_server_error", "Erro ao inserir item", "error")->back();
            return;
        }

        $this->call(201, "created", "Item adicionado ao pedido", "success")->back([
            "idOrder" => $item->getIdOrder(),
            "idProduct" => $item->getIdProduct(),
            "quantity" => $item->getQuantity(),
            "unitPrice" => $item->getUnitPrice()
        ]);
    }

    public function listItemsByOrder(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID do pedido inválido", "error")->back();
            return;
        }

        $item = new OrderItem();
        $results = $item->find("idOrder = :id", "id={$data['id']}")->fetch(true);

        if (!$results) {
            $this->call(200, "success", "Nenhum item encontrado para este pedido", "info")->back([]);
            return;
        }

        $itens = [];
        foreach ($results as $result) {
            $itens[] = [
                "id" => $result->id,
                "idProduct" => $result->idProduct,
                "quantity" => $result->quantity,
                "unitPrice" => $result->unitPrice
            ];
        }

        $this->call(200, "success", "Itens encontrados", "success")->back($itens);
    }
}