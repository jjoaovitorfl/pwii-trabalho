<?php

$this->layout("_theme", [
    "title" => "Painel Administrativo",
    "css" => "inicio-admin"
]);

?>

<div class="painel-adm">
    <h2>Bem-vindo ao Painel Administrativo</h2>
    <p>Gerencie usuários, feirantes e feiras do sistema FeiraFácil.</p>

    <div class="cards">
        <div class="card">
            <h3>Gerenciar Usuários</h3>
            <p>Cadastre, edite e remova usuários do sistema.</p>
            <a href="<?= url("/admin/painel-admin") ?>" class="btn">Acessar</a>
        </div>

        <div class="card">
            <h3>Gerenciar Feirantes</h3>
            <p>Controle os feirantes cadastrados.</p>
            <a href="<?= url("/admin/painel-admin") ?>" class="btn">Acessar</a>
        </div>

        <div class="card">
            <h3>Gerenciar Feiras</h3>
            <p>Adicione, edite ou remova feiras do sistema.</p>
            <a href="<?= url("/admin/painel-admin") ?>" class="btn">Acessar</a>
        </div>
    </div>
</div>