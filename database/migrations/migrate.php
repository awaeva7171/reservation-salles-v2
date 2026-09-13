<?php
declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
$capsule = require __DIR__ . '/../../config/database.php';

$schema = $capsule->schema();

if (!$schema->hasTable('salle')) {
    $schema->create('salle', function ($table) {
        $table->id();
        $table->string('nom', 100);
        $table->string('batiment', 100);
        $table->integer('capacite');
        $table->enum('type', ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion']);
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
    echo "Table 'salle' créée.\n";
} else {
    echo "Table 'salle' déjà existante.\n";
}

if (!$schema->hasTable('reservation')) {
    $schema->create('reservation', function ($table) {
        $table->id();
        $table->unsignedBigInteger('salle_id');
        $table->string('responsable', 120);
        $table->string('email');
        $table->string('motif', 255);
        $table->dateTime('date_debut');
        $table->dateTime('date_fin');
        $table->enum('statut', ['confirmee', 'annulee'])->default('confirmee');
        $table->timestamps();
        $table->foreign('salle_id')->references('id')->on('salle');
    });
    echo "Table 'reservation' créée.\n";
} else {
    echo "Table 'reservation' déjà existante.\n";
}

//commande pour lance: php database/migrations/migrate.php