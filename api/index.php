<?php

ob_start();

require  __DIR__ . "/../vendor/autoload.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Credentials: true'); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

use CoffeeCode\Router\Router;

$route = new Router("http://localhost/trabalhopwii/api", ":");

$route->namespace("Source\WebService");

// rotas dos usuarios
$route->group("/users");
$route->get("/", "Users:listUsers");
$route->get("/id/{id}", "Users:listUserById");
$route->get("/id/", "Users:listUserById");
$route->post("/", "Users:createUser");
$route->put("/id/{id}", "Users:updateUser");
$route->delete("/id/{id}", "Users:deleteUser");
$route->group(null); 

// rotas dos produtos
$route->group("/products");
$route->get("/", "Products:listProducts");
$route->get("/id/{id}", "Products:listProductById");
$route->post("/", "Products:createProduct");
$route->put("/id/{id}", "Products:updateProduct");
$route->delete("/id/{id}", "Products:deleteProduct");
$route->group(null); 

// rota de feiras
$route->group("/markets");
$route->get("/", "Markets:listMarkets");
$route->get("/id/{id}", "Markets:listMarketById");
$route->post("/", "Markets:createMarket");
$route->put("/id/{id}", "Markets:updateMarket");
$route->delete("/id/{id}", "Markets:deleteMarket");
$route->group(null);

// rota dos pedidos 
$route->group("/orders");
$route->get("/", "Orders:listOrders");
$route->get("/id/{id}", "Orders:getOrderById");
$route->post("/", "Orders:createOrder");
$route->delete("/id/{id}", "Orders:deleteOrder");
$route->group(null);

// rota de itens dos pedidos 
$route->group("/order-items");
$route->get("/order/{id}", "OrderItems:listItemsByOrder");
$route->post("/", "OrderItems:createItem");
$route->group(null);

// rota de avaliacoes
$route->group("/reviews");
$route->get("/", "Reviews:listReviews");
$route->get("/market/{id}", "Reviews:listByMarket");
$route->get("/product/{id}", "Reviews:listByProduct");
$route->post("/", "Reviews:createReview");
$route->group(null);

// rota de endereços
$route->group("/addresses");
$route->get("/user/{id}", "Addresses:listByUser");
$route->post("/", "Addresses:createAddress");
$route->put("/id/{id}", "Addresses:updateAddress");
$route->delete("/id/{id}", "Addresses:deleteAddress");
$route->group(null);

// rota dos horarios das feiras 
$route->group("/market-schedules");
$route->get("/market/{id}", "MarketSchedules:listByMarket");
$route->post("/", "MarketSchedules:createSchedule");
$route->put("/id/{id}", "MarketSchedules:updateSchedule");
$route->delete("/id/{id}", "MarketSchedules:deleteSchedule");
$route->group(null);

// rota de estoque dos pedidos 
$route->group("/product-stock");
$route->get("/product/{id}", "ProductStockController:getStockByProduct");
$route->put("/product/{id}", "ProductStockController:updateStock");
$route->group(null);

// rota de teste (ping)
$route->group("/ping");
$route->get("/", "TesteAPI:ping");
$route->group(null);


$route->dispatch();

// erro quando não encontra requisição
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(404);

    echo json_encode([
        "errors" => [
            "type" => "endpoint_not_found",
            "message" => "Não foi possível processar a requisição"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

ob_end_flush();
