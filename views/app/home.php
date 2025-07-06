<?php

$this->layout("_theme", [
    "title" => "Início",
]);

?>

<div class="inicio-app">
    <h2>Bem-vindo ao FeiraFácil!</h2>
    <p>O que você deseja fazer hoje?</p>

    <div class="cards">
        <div class="card">
            <h3>Explorar Feiras</h3>
            <p>Veja as feiras disponíveis na sua região e comece suas compras.</p>
            <a href="<?= url("/app/feiras") ?>" class="btn">Ver Feiras</a>
        </div>

        <div class="card">
            <h3>Painel do Cliente</h3>
            <p>Acompanhe seu histórico de compras e gerencie seus pedidos.</p>
            <a href="<?= url("/app/painel-cliente") ?>" class="btn">Acessar</a>
        </div>

        <div class="card">
            <h3>Painel do Feirante</h3>
            <p>Gerencie seus produtos, suas feiras e seus pedidos recebidos.</p>
            <a href="<?= url("/app/painel-feirante") ?>" class="btn">Acessar</a>
        </div>
    </div>
</div>