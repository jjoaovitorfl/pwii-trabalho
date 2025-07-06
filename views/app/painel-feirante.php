<?php

$this->layout("_theme", [
    "title" => "Painel - Feirante"
]);

?>

<main>
    <section class="painel-container">
      <h2>Painel do Feirante</h2>

      <div class="selecionar-feira">
        <h3>Selecionar Feira para Participar</h3>
        <select id="feiraSelect">
          <option value="">-- Escolha uma feira --</option>
        </select>
      </div>

      <div class="gerenciar-produtos" style="display:none;">
        <h3>Gerenciar Produtos da Feira Selecionada</h3>
        <p><button id="addProdutoBtn">Adicionar Produto</button></p>
        <div id="produtosList"></div>
      </div>
    </section>
  </main>