<?php

 $this->layout("_theme",[
    "title" => "Sobre",
 ]);

?>

<h1>Sobre o FeiraFácil</h1>
<a href="<?= url() ?>" class="volt">Voltar para Início</a>
<br>
<section>
    <h2>O que é o FeiraFácil?</h2>
    <p>
        FeiraFácil é um sistema web que facilita a compra e venda de produtos em
        feiras locais. Com ele, feirantes podem cadastrar suas bancas e produtos,
        e clientes podem visualizar, comprar e acompanhar pedidos com praticidade.
    </p>
</section>

<section>
    <h2>Como usar?</h2>
    <ul>
        <li>Clientes devem se cadastrar e fazer login.</li>
        <li>Após logado, navegue pela página de produtos e adicione o que quiser ao carrinho.</li>
        <li>Finalize o pedido no carrinho e acompanhe no histórico.</li>
        <li>Feirantes devem se cadastrar e usar o painel para gerenciar banca, produtos e pedidos recebidos.</li>
    </ul>
</section>

<section>
    <h2>Dúvidas frequentes</h2>
    <div class="acordeao">
        <button class="acordeao-btn">Esqueci minha senha</button>
        <div class="acordeao-conteudo">
            <p>Ainda não temos sistema de recuperação automática. Contate o suporte.</p>
        </div>

        <button class="acordeao-btn">Não consigo ver os pedidos</button>
        <div class="acordeao-conteudo">
            <p>Verifique se está logado e se há pedidos finalizados no histórico.</p>
        </div>

        <button class="acordeao-btn">Posso comprar de várias bancas ao mesmo tempo?</button>
        <div class="acordeao-conteudo">
            <p>Por enquanto, o sistema aceita pedidos de uma banca por vez.</p>
        </div>
    </div>
</section>

<script src="<?= url("assets/web/js/sobre.js")?> "> </script>