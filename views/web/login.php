<?php

$this->layout("_theme", ["title" => "Login"]);

?>

<div class="page-login">
    <div class="login-container">
        <h2>Login FeiraFácil</h2>

        <form action="#" method="post" id="formLogin">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required>

            <select id="tipo">
                <option value="cliente">Cliente</option>
                <option value="feirante">Feirante</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Entrar</button>
            <div id="resp"></div>
        </form>

        <p>Não tem uma conta? <a href="<?= url("cadastro") ?>">Cadastre-se</a></p>
    </div>
</div>