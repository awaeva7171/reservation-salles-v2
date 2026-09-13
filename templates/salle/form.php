<?php require __DIR__ . '/../layout/base.php'; ?>

<h1><?= $salle ? 'Modifier la salle' : 'Ajouter une salle' ?></h1>

<?php if (!empty($errors['global'])): ?>
    <div class="erreur"><?= htmlspecialchars($errors['global'][0]) ?></div>
<?php endif; ?>

<form method="post" action="<?= $salle ? '/salles/' . $salle->id . '/edit' : '/salles' ?>">
    <label>Nom
        <input type="text" name="nom" value="<?= htmlspecialchars($old['nom'] ?? $salle->nom ?? '') ?>">
    </label>
    <?php if (!empty($errors['nom'])): ?><p class="erreur"><?= htmlspecialchars($errors['nom'][0]) ?></p><?php endif; ?>

    <label>Batiment
        <input type="text" name="batiment" value="<?= htmlspecialchars($old['batiment'] ?? $salle->batiment ?? '') ?>">
    </label>
    <?php if (!empty($errors['batiment'])): ?><p class="erreur"><?= htmlspecialchars($errors['batiment'][0]) ?></p><?php endif; ?>

    <label>Capacite
        <input type="number" name="capacite" value="<?= htmlspecialchars((string) ($old['capacite'] ?? $salle->capacite ?? '')) ?>">
    </label>
    <?php if (!empty($errors['capacite'])): ?><p class="erreur"><?= htmlspecialchars($errors['capacite'][0]) ?></p><?php endif; ?>

    <label>Type
        <select name="type">
            <?php foreach (['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'] as $type): ?>
                <option value="<?= $type ?>" <?= ($old['type'] ?? $salle->type ?? '') === $type ? 'selected' : '' ?>><?= $type ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Active
        <input type="checkbox" name="active" value="1" <?= ($old['active'] ?? $salle->active ?? true) ? 'checked' : '' ?>>
    </label>

    <button type="submit">Enregistrer</button>
    <a href="/salles">Annuler</a>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
