<?php

$this->layout("_theme", [
    "title" => "Página Inicial",
    "description" => "Compre diretamente dos feirantes locais, de forma simples, rápida e segura."
]);

?>

<section class="hero">
    <h2>Conectando você à feira mais próxima</h2>
    <p>Compre diretamente dos feirantes locais, de forma simples, rápida e segura.</p>
    <a href="<?= url("login") ?>" class="btn">Logue ou cadastre-se para ter acesso às feiras!</a>
</section>

<section class="info">
    <h3>Por que usar o FeiraFácil?</h3>
    <ul>
        <li>🌿 Produtos frescos direto do produtor</li>
        <li>🚜 Apoie os pequenos agricultores</li>
        <li>💰 Preços acessíveis e sem intermediários</li>
        <li>⚙️ Simples e prático de usar</li>
    </ul>
</section>