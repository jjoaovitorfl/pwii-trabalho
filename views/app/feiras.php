<?php

$this->layout("_theme", [
    "title" => "Feiras"
]);

?>

<section class="feiras-container">
    <h2>Feiras disponíveis na sua região</h2>
    <div id="listaFeiras"></div>
</section>

<section class="carrinho-container">
    <h3>Carrinho de Compras</h3>
    <ul id="listaCarrinho"></ul>
    <p class="carrinho-total" id="carrinhoTotal">Total: R$ 0.00</p>
    <button id="finalizarCompraBtn">Finalizar Compra</button>
</section>