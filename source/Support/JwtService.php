<?php

namespace Source\Support;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtService
{
    private string $secret = "chave-secreta-muito-forte"; 

    public function gerar(array $payload): string
    {
        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function validar(string $jwt): object|bool
    {
        try {
            return JWT::decode($jwt, new Key($this->secret, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}
