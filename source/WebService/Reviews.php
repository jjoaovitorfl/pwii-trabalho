<?php

namespace Source\WebService;

use Source\Models\Review;
use Source\Support\JwtService;

class Reviews extends Api
{
    public function listReviews(): void
    {
        $reviews = new Review();
        $this->call(200, "success", "Lista de avaliações", "success")
            ->back($reviews->findAll());
    }

    public function listByMarket(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID da feira inválido", "error")->back();
            return;
        }

        $review = new Review();
        $result = $review->findByMarket($data["id"]);

        $this->call(200, "success", "Avaliações da feira carregadas", "success")
            ->back($result);
    }

    public function listByProduct(array $data): void
    {
        if (!isset($data["id"]) || !filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID do produto inválido", "error")->back();
            return;
        }

        $review = new Review();
        $result = $review->findByProduct($data["id"]);

        $this->call(200, "success", "Avaliações do produto carregadas", "success")
            ->back($result);
    }

    public function createReview(): void
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
            (!isset($data["idMarket"]) && !isset($data["idProduct"])) ||
            empty($data["rating"])
        ) {
            $this->call(400, "bad_request", "Dados incompletos para avaliação", "error")->back();
            return;
        }

        $review = new Review(
            null,
            $data["idUser"],
            $data["idProduct"] ?? null,
            $data["idMarket"] ?? null,
            $data["rating"],
            $data["comment"] ?? null
        );

        if (!$review->insert()) {
            $this->call(500, "internal_server_error", $review->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(201, "created", "Avaliação registrada com sucesso", "success")
            ->back([
                "idUser" => $review->getIdUser(),
                "idProduct" => $review->getIdProduct(),
                "idMarket" => $review->getIdMarket(),
                "rating" => $review->getRating(),
                "comment" => $review->getComment()
            ]);
    }
}