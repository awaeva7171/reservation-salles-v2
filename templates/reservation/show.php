<?php require __DIR__ . '/../layout/base.php'; ?>

<h1>Reservation #<?= $reservation->id ?></h1>
<div class="carte">
    <p><strong>Salle :</strong> <a href="/salles/<?= $reservation->salle_id ?>"><?= htmlspecialchars((string) $reservation->salle_id) ?></a></p>
    <p><strong>Responsable :</strong> <?= htmlspecialchars($reservation->responsable) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($reservation->email) ?></p>
    <p><strong>Motif :</strong> <?= htmlspecialchars($reservation->motif) ?></p>
    <p><strong>Debut :</strong> <?= htmlspecialchars($reservation->date_debut->format('d/m/Y H:i')) ?></p>
    <p><strong>Fin :</strong> <?= htmlspecialchars($reservation->date_fin->format('d/m/Y H:i')) ?></p>
    <p><strong>Statut :</strong> <span class="badge badge-<?= $reservation->statut ?>"><?= htmlspecialchars($reservation->statut) ?></span></p>
</div>

<?php if ($reservation->statut === 'confirmee'): ?>
<form method="post" action="/reservations/<?= $reservation->id ?>/cancel">
    <button type="submit" class="btn btn-danger">Annuler la reservation</button>
</form>
<?php endif; ?>

<a href="/reservations" class="btn btn-secondary">Retour a la liste</a>

<?php require __DIR__ . '/../layout/footer.php'; ?>
