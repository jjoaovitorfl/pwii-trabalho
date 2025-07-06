<!DOCTYPE html>
<html lang="pt-BR">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "FeiraFácil - App" ?></title>


    <?php if ($title == "Feiras"): ?>
        <link rel="stylesheet" href="<?= url("assets/app/css/feiras.css") ?>">
    <?php endif; ?>

    <?php if ($title == "Painel - Cliente"): ?>
        <link rel="stylesheet" href="<?= url("assets/app/css/painel-cliente.css") ?>">
    <?php endif; ?>

    <?php if ($title == "Painel - Feirante"): ?>
        <link rel="stylesheet" href="<?= url("assets/app/css/painel-feirante.css") ?>">
    <?php endif; ?>

    <?php if ($title == "Início"): ?>
        <link rel="stylesheet" href="<?= url("assets/app/css/inicio.css") ?>">
    <?php endif; ?>

</head>

<body>
    <header>
        <h1>FeiraFácil - App</h1>
        <nav>
            <ul>
                <li><a href="<?= url("app") ?>">Início</a></li>
                <li><a href="<?= url("app/feiras") ?>">Feiras</a></li>
                <li><a href="<?= url("app/painel-cliente") ?>">Painel Cliente</a></li>
                <li><a href="<?= url("app/painel-feirante") ?>">Painel Feirante</a></li>
                <li><a href="<?= url("") ?>">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?= $this->section("content") ?>
    </main>

    <footer>
        <p>FeiraFácil &copy; <?= date("Y") ?> - Aplicativo</p>
    </footer>

    <?php if ($title == "Feiras"): ?>
        <script src="<?= url("assets/app/js/feiras.js") ?>"></script>
    <?php endif; ?>

    <?php if ($title == "Painel - Cliente"): ?>
        <script src="<?= url("assets/app/js/painel-cliente.js") ?>"></script>
    <?php endif; ?>

    <?php if ($title == "Painel - Feirante"): ?>
        <script src="<?= url("assets/app/js/painel-feirante.js") ?>"></script>
    <?php endif; ?>
</body>
</html>