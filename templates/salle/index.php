<?php require __DIR__ . '/../layout/base.php'; ?>

<h1>Liste des salles</h1>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Batiment</th>
            <th>Capacite</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($salles as $salle): ?>
        <tr>
            <td><?= htmlspecialchars($salle->nom) ?></td>
            <td><?= htmlspecialchars($salle->batiment) ?></td>
            <td><?= htmlspecialchars((string) $salle->capacite) ?></td>
            <td><?= htmlspecialchars($salle->type) ?></td>
            <td><?= $salle->active ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="/salles/<?= $salle->id ?>">Voir</a>
                <a href="/salles/<?= $salle->id ?>/edit">Modifier</a>
                <a href="/reservations?salle_id=<?= $salle->id ?>">Reservations</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>
