<?php require __DIR__ . '/../layout/base.php'; ?>

<h1>Creer une reservation</h1>

<?php if (!empty($errors['global'])): ?>
    <div class="erreur"><?= htmlspecialchars($errors['global'][0]) ?></div>
<?php endif; ?>

<form method="post" action="/reservations">
    <label>Salle (ID)
        <input type="number" name="salle_id" value="<?= htmlspecialchars((string) ($old['salle_id'] ?? '')) ?>">
    </label>
    <?php if (!empty($errors['salle_id'])): ?><p class="erreur"><?= htmlspecialchars($errors['salle_id'][0]) ?></p><?php endif; ?>

    <label>Responsable
        <input type="text" name="responsable" value="<?= htmlspecialchars($old['responsable'] ?? '') ?>">
    </label>
    <?php if (!empty($errors['responsable'])): ?><p class="erreur"><?= htmlspecialchars($errors['responsable'][0]) ?></p><?php endif; ?>

    <label>Email
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    </label>
    <?php if (!empty($errors['email'])): ?><p class="erreur"><?= htmlspecialchars($errors['email'][0]) ?></p><?php endif; ?>

    <label>Motif
        <input type="text" name="motif" value="<?= htmlspecialchars($old['motif'] ?? '') ?>">
    </label>
    <?php if (!empty($errors['motif'])): ?><p class="erreur"><?= htmlspecialchars($errors['motif'][0]) ?></p><?php endif; ?>

    <label>Date de debut
        <input type="datetime-local" name="date_debut" value="<?= htmlspecialchars($old['date_debut'] ?? '') ?>">
    </label>
    <?php if (!empty($errors['date_debut'])): ?><p class="erreur"><?= htmlspecialchars($errors['date_debut'][0]) ?></p><?php endif; ?>

    <label>Date de fin
        <input type="datetime-local" name="date_fin" value="<?= htmlspecialchars($old['date_fin'] ?? '') ?>">
    </label>
    <?php if (!empty($errors['date_fin'])): ?><p class="erreur"><?= htmlspecialchars($errors['date_fin'][0]) ?></p><?php endif; ?>

    <button type="submit" class="btn btn-primary">Reserver</button>
    <a href="/reservations" class="btn btn-secondary">Annuler</a>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
