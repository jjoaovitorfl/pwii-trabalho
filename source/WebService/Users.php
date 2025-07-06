<?php

namespace Source\WebService;

use Source\Models\User;
use Source\Support\JwtService;

class Users extends Api
{
    public function listUsers(): void
    {
        $users = new User();
        $this->call(200, "success", "Lista de usuários", "success")
            ->back($users->findAll());
    }

    public function createUser()
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

        $user = new User(
            null,
            $data["idType"] ?? null,
            $data["name"] ?? null,
            $data["email"] ?? null,
            $data["password"] ?? null
        );

        if (!$user->insert()) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "photo" => $user->getPhoto()
        ];

        $this->call(201, "created", "Usuário criado com sucesso", "success")
            ->back($response);
    }

    public function listUserById(array $data): void
    {
        if (!isset($data["id"])) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        if (!filter_var($data["id"], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID inválido", "error")->back();
            return;
        }

        $user = new User();
        if (!$user->findById($data["id"])) {
            $this->call(200, "error", "Usuário não encontrado", "error")->back();
            return;
        }

        $response = [
            "name" => $user->getName(),
            "email" => $user->getEmail()
        ];

        $this->call(200, "success", "Encontrado com sucesso", "success")->back($response);
    }

    public function updateUser(array $data): void
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

        $user = new User();
        if (!$user->findById($data["id"])) {
            $this->call(404, "not_found", "Usuário não encontrado", "error")->back();
            return;
        }

        $user->setName($data["name"] ?? $user->getName());
        $user->setEmail($data["email"] ?? $user->getEmail());
        $user->setPassword($data["password"] ?? $user->getPassword());

        if (!$user->update()) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Usuário atualizado com sucesso", "success")
            ->back([
                "name" => $user->getName(),
                "email" => $user->getEmail()
            ]);
    }

    public function deleteUser(array $data): void
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

        $user = new User();
        if (!$user->findById($data["id"])) {
            $this->call(404, "not_found", "Usuário não encontrado", "error")->back();
            return;
        }

        if (!$user->delete()) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200, "success", "Usuário deletado com sucesso", "success")->back();
    }
}