<?php

$this->layout("_theme", ["title" => "Cadastro"]);

?>

<div class="page-cadastro">
    <div class="cadastro-container">
        <h2>Cadastro FeiraFácil</h2>

        <form action="#" method="post" id="formRegister">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <label for="tipo">Tipo de Conta:</label>
            <select name="tipo" id="tipo" required>
                <option value="">Selecione...</option>
                <option value="cliente">Cliente</option>
                <option value="feirante">Feirante</option>
            </select>

            <div id="mensagemCadastro"></div>

            <button type="submit">Cadastrar</button>
        </form>

        <p>Já tem uma conta? <a href="<?= url("login") ?>">Fazer login</a></p>
    </div>
</div>