<?php require __DIR__ . '/../layout/base.php'; ?>

<h1><?= htmlspecialchars($salle->nom) ?></h1>
<p>Batiment : <?= htmlspecialchars($salle->batiment) ?></p>
<p>Capacite : <?= htmlspecialchars((string) $salle->capacite) ?></p>
<p>Type : <?= htmlspecialchars($salle->type) ?></p>
<p>Statut : <?= $salle->active ? 'Active' : 'Inactive' ?></p>

<a href="/salles/<?= $salle->id ?>/edit">Modifier cette salle</a>
<a href="/reservations?salle_id=<?= $salle->id ?>">Voir ses reservations</a>
<a href="/reservations/create">Reserver cette salle</a>
<a href="/salles">Retour a la liste</a>

<?php require __DIR__ . '/../layout/footer.php'; ?>
