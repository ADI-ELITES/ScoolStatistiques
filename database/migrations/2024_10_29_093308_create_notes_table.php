<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            //$table->id();
            $table->string('niveau', 4);
            $table->string('serie', 4);
            $table->string('codeclas', 1);
            $table->string('matric', 14);
            $table->string('periode', 2);
            $table->string('matiere', 25);
            $table->float('devoir01');
            $table->float('devoir02');
            $table->float('devoir03');
            $table->float('compos');
            $table->timestamps();
            $table->primary(['niveau', 'serie', 'codeclas', 'matric', 'periode', 'matiere']);

            // Définir une clé étrangère composite en utilisant `foreign`, `references` et `on`
            $table->foreign(['niveau', 'serie', 'codeclas', 'matric'])
                ->references(['niveau', 'serie', 'codeclas', 'matric'])
                ->on('eleves')
                ->onDelete('cascade');

            // Clé étrangère composite vers la table `matieres`
            $table->foreign(['niveau', 'serie', 'codeclas', 'matiere'])
                ->references(['niveau', 'serie', 'codeclas', 'nomatiere'])
                ->on('matieres')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
