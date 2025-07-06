<?php

namespace Source\WebService;

use Source\Models\Order;
use Source\Support\JwtService;

class Orders extends Api
{
    public function listOrders(): void
    {
        $orders = new Order();
        $this->call(200, "success", "Lista de pedidos", "success")
            ->back($orders->findAll());
    }

    public function getOrderById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        $order = new Order();
        if (!$order->findById($data["id"])) {
            $this->call(404, "not_found", "Pedido não encontrado", "error")->back();
            return;
        }

        $this->call(200, "success", "Pedido encontrado com sucesso", "success")
            ->back($order->getData());
    }

    public function createOrder(): void
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
            empty($data["idUser"]) ||
            empty($data["idMarket"]) ||
            empty($data["totalValue"])
        ) {
            $this->call(400, "bad_request", "Dados incompletos para criar o pedido", "error")->back();
            return;
        }

        $order = new Order(
            null,
            $data["idUser"],
            $data["idMarket"],
            $data["totalValue"],
            $data["status"] ?? "pendente"
        );

        if (!$order->insert()) {
            $this->call(500, "internal_server_error", $order->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(201, "created", "Pedido criado com sucesso", "success")
            ->back($order->getData());
    }

    public function deleteOrder(array $data): void
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

        $order = new Order();
        if (!$order->findById($data["id"])) {
            $this->call(404, "not_found", "Pedido não encontrado", "error")->back();
            return;
        }

        if (!$order->delete()) {
            $this->call(500, "internal_server_error", $order->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Pedido deletado com sucesso", "success")->back();
    }
}