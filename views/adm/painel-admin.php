<?php

$this->layout("_theme", [
    "title" => "Painel Admin",
    "css" => "painel-admin",
    "js" => "painel-admin"
]);

?>

<section class="painel-container">
    <h2>Painel Administrativo</h2>

    <div class="painel-bloco">
        <h3>Usuários Cadastrados
            <button id="btnAddUsuario" class="adicionar">+ Adicionar Usuário</button>
        </h3>
        <ul id="listaUsuarios"></ul>
    </div>

    <div class="painel-bloco">
        <h3>Feirantes
            <button id="btnAddFeirante" class="adicionar">+ Adicionar Feirante</button>
        </h3>
        <ul id="listaFeirantes"></ul>
    </div>

    <div class="painel-bloco">
        <h3>Feiras Ativas
            <button id="btnAddFeira" class="adicionar">+ Adicionar Feira</button>
        </h3>
        <ul id="listaFeiras"></ul>
    </div>
</section>