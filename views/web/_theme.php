<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'RoomManager - Gestão de Salas de Reunião' ?></title>
    <meta name="description" content="<?= $description ?? 'Sistema completo para gerenciamento e agendamento de salas de reunião para pequenas e médias empresas' ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<link rel="stylesheet" href="<?= url("assets/css/base.css") ?>">

    <?php if($title == "Página Inicial"): ?>
        <link rel="stylesheet" href="<?= url("assets/web/css/inicio.css") ?>">
    <?php endif; ?>

    <?php if($title == "Login"): ?>
        <link rel="stylesheet" href="<?= url("assets/web/css/login.css") ?>">
    <?php endif; ?>

    <?php if($title == "Sobre"): ?>
        <link rel="stylesheet" href="<?= url("assets/web/css/sobre.css") ?>">
    <?php endif; ?>

    <?php if($title == "Cadastro"): ?>
        <link rel="stylesheet" href="<?= url("assets/web/css/cadastro.css") ?>">
    <?php endif; ?>

    <?php if($title == "FAQ"): ?>
        <link rel="stylesheet" href="<?= url("assets/web/css/faq.css") ?>">
    <?php endif; ?>

</head>
<body>

<header>
    <div class="header-container">
        <h1><a href="<?= url("/") ?>">FeiraFácil</a></h1>
        <nav>
            <ul>
                <li><a href="<?= url() ?>">Início</a></li>
                <li><a href="<?= url("sobre") ?>">Sobre</a></li>
                <li><a href="<?= url("faq") ?>">FAQs</a></li>
                <li><a href="<?= url("cadastro") ?>">Cadastro</a></li>
                <li><a href="<?= url("login") ?>">Login</a></li>
            </ul>
        </nav>
    </div>
</header>

    <main>
        <?= $this->section("content") ?>
    </main>

</body>

    <?php if ($title == "FAQ"): ?>
        <script src="<?= url("assets/web/js/faq.js") ?>"></script>
    <?php endif; ?>

    <?php if ($title == "Cadastro"): ?>
        <script src="<?= url("assets/web/js/cadastro.js") ?>"></script>
    <?php endif; ?>

    <?php if ($title == "Login"): ?>
        <script src="<?= url("assets/web/js/login.js") ?>"></script>
    <?php endif; ?>

</html>