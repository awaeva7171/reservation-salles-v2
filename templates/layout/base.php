<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Gestion des reservations de salles') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/salles">Salles</a>
            <a href="/salles/create">Ajouter une salle</a>
            <a href="/reservations">Reservations</a>
            <a href="/reservations/create">Nouvelle reservation</a>
        </nav>
    </header>
    <main>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="succes"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>
</html>
