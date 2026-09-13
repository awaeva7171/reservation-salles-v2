<?php require __DIR__ . '/../layout/base.php'; ?>

<h1>Liste des reservations</h1>

<table>
    <thead>
        <tr>
            <th>Salle</th>
            <th>Responsable</th>
            <th>Debut</th>
            <th>Fin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?= htmlspecialchars((string) $reservation->salle_id) ?></td>
            <td><?= htmlspecialchars($reservation->responsable) ?></td>
            <td><?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?></td>
            <td><?= htmlspecialchars($reservation->date_fin->format('d/m/Y H:i')) ?></td>
            <td><span class="badge badge-<?= $reservation->statut ?>"><?= htmlspecialchars($reservation->statut) ?></span></td>
            <td><a href="/reservations/<?= $reservation->id ?>" class="btn btn-small">Voir</a></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($reservations)): ?>
        <tr><td colspan="6">Aucune reservation pour le moment.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>
