<?php

namespace Source\WebService;

use Source\Models\Product;
use Source\Support\JwtService;

class Products extends Api
{
    public function listProducts(): void
    {
        $products = new Product();
        $this->call(200, "success", "Lista de produtos", "success")->back($products->findAll());
    }

    public function createProduct(array $data)
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

        if (in_array("", $data)) {
            $this->call(400, "bad_request", "Dados inválidos", "error")->back();
            return;
        }

        $product = new Product(
            null,
            $data["idCategory"] ?? null,
            $data["name"] ?? null,
            $data["price"] ?? null
        );

        if (!$product->insert()) {
            $this->call(500, "internal_server_error", $product->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "name" => $product->getName(),
            "price" => $product->getPrice()
        ];

        $this->call(201, "created", "Produto criado com sucesso", "success")->back($response);
    }

    public function listProductById(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        $product = new Product();
        if (!$product->findById($data["id"])) {
            $this->call(200, "error", "Produto não encontrado", "error")->back();
            return;
        }

        $response = [
            "name" => $product->getName(),
            "price" => $product->getPrice()
        ];

        $this->call(200, "success", "Encontrado com sucesso", "success")->back($response);
    }

    public function updateProduct(array $data): void
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

        if (in_array("", $data)) {
            $this->call(400, "bad_request", "Dados inválidos", "error")->back();
            return;
        }

        $product = new Product();
        if (!$product->findById($data["id"])) {
            $this->call(404, "not_found", "Produto não encontrado", "error")->back();
            return;
        }

        $product->setName($data["name"] ?? $product->getName());
        $product->setPrice($data["price"] ?? $product->getPrice());
        $product->setIdCategory($data["idCategory"] ?? $product->getIdCategory());

        if (!$product->update()) {
            $this->call(500, "internal_server_error", $product->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Produto atualizado com sucesso", "success")
            ->back([
                "name" => $product->getName(),
                "price" => $product->getPrice()
            ]);
    }

    public function deleteProduct(array $data): void
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

        $product = new Product();
        if (!$product->findById($data["id"])) {
            $this->call(404, "not_found", "Produto não encontrado", "error")->back();
            return;
        }

        if (!$product->delete()) {
            $this->call(500, "internal_server_error", $product->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Produto deletado com sucesso", "success")->back();
    }
}