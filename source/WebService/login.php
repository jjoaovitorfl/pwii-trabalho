<?php
require __DIR__ . "/../../vendor/autoload.php";

use Source\Support\JwtService;

header("Content-Type: application/json");

$dados = json_decode(file_get_contents("php://input"), true);

$email = $dados["email"] ?? null;
$senha = $dados["senha"] ?? null;
$tipo  = $dados["tipo"] ?? null;

if (!$email || !$senha || !$tipo) {
    http_response_code(400);
    echo json_encode(["error" => "Dados incompletos"]);
    exit;
}

if ($tipo === "administrador") {
    if ($email === "admin@gmail.com" && $senha === "123456") {
        $token = (new JwtService())->gerar([
            "email" => $email,
            "tipo" => $tipo,
            "exp" => time() + 3600
        ]);

        echo json_encode(["token" => $token]);
        exit;
    }
}

$caminhoArquivo = __DIR__ . "/../../dados/{$tipo}s.json";

if (!file_exists($caminhoArquivo)) {
    http_response_code(400);
    echo json_encode(["error" => "Tipo de usuário inválido"]);
    exit;
}

$lista = json_decode(file_get_contents($caminhoArquivo), true) ?? [];

foreach ($lista as $usuario) {
    if ($usuario["email"] === $email && $usuario["senha"] === $senha) {
        $token = (new JwtService())->gerar([
            "email" => $usuario["email"],
            "tipo" => $usuario["tipo"],
            "exp" => time() + 3600
        ]);

        echo json_encode(["token" => $token]);
        exit;
    }
}

http_response_code(401);
echo json_encode(["error" => "Credenciais inválidas"]);