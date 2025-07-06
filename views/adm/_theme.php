<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'FeiraFácil - Admin' ?></title>

    <?php if($title == "Painel Admin"): ?>
        <link rel="stylesheet" href="<?= url("assets/adm/css/painel-admin.css") ?>">
    <?php endif; ?>

    <?php if($title == "Painel Administrativo"): ?>
        <link rel="stylesheet" href="<?= url("assets/adm/css/inicio-admin.css") ?>">
    <?php endif; ?>

</head>
<body>

    <header style="background-color: rgb(24, 36, 64);color:white;padding:1rem;text-align:center;">
        <h1>FeiraFácil - Área Administrativa</h1>
        <nav>
            <a href="<?= url("") ?>">Início</a> 
        </nav>
    </header>

    <main>
        <?= $this->section("content") ?>
    </main>

    <footer style="background-color:rgb(24, 36, 64);padding:1rem;text-align:center;">
        <p>FeiraFácil © <?= date("Y") ?> - Admin</p>
    </footer>
    
</body>

    <?php if ($title == "Painel Admin"): ?>
        <script src="<?= url("assets/adm/js/painel-admin.js") ?>"></script>
    <?php endif; ?>

</html>
