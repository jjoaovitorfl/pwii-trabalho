<?php

require_once __DIR__ . "/vendor/autoload.php";

use Source\Web\Site;
use CoffeeCode\Router\Router;

ob_start();

$route = new Router("http://localhost/trabalhopwii", ":");
$route->namespace("Source\\Web");

// Rotas públicas
$route->get("/", "Site:home");
$route->get("/sobre", "Site:about");
$route->get("/faq", "Site:faqs");
$route->get("/login", "Site:login");
$route->get("/cadastro", "Site:register");

// Área do usuário 
$route->group("app");
$route->get("/", "App:home");                
$route->get("/feiras", "App:feiras");       
$route->get("/painel-cliente", "App:painelCliente");  
$route->get("/painel-feirante", "App:painelFeirante"); 

$route->group(null);

// Área administrativa 
$route->group("admin");
$route->get("/", "Admin:home");
$route->get("/painel-admin", "Admin:painelAdmin");

$route->group(null);


$route->get("/ops/{errcode}", "Site:error");

$route->dispatch();

if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();