<?php

$this->layout("_theme", [
    "title" => "Painel - Cliente"
]);

?>

  <main>
    <section class="container">
      <div class="card">
        <h2>Informações de Login</h2>
        <p><strong>Email:</strong> <span id="emailUsuario"></span></p>
        <p><strong>Tipo:</strong> <span id="tipoUsuario"></span></p>
        <button class="btn" id="btnEditarLogin">Editar</button>
      </div>

      <div class="card" id="informacoesAdicionaisBloco">
        <h2>Informações Adicionais</h2>
        <p><strong>Endereço:</strong> <span id="enderecoUsuario"></span></p>
        <p><strong>CPF:</strong> <span id="cpfUsuario"></span></p>
        <button class="btn" id="btnEditarDadosAdicionais">Editar</button>
      </div>

      <div id="formDadosAdicionais">
        <h2>Editar Informações Adicionais</h2>
        <form>
          <label for="endereco">Endereço</label>
          <input type="text" id="endereco" placeholder="Digite seu endereço">
          <label for="cpf">Telefone</label>
          <input type="text" id="cpf" placeholder="Digite seu telefone">
          <button type="submit">Salvar</button>
        </form>
      </div>
    </section>

    <section class="container">
      <h2>Histórico de Compras</h2>
      <ul id="historicoCompras"></ul>
    </section>
  </main>