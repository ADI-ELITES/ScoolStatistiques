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
        Schema::create('matieres', function (Blueprint $table) {
            //$table->id();
            $table->string('niveau', 4);
            $table->string('serie', 4);
            $table->string('codeclas', 1);
            $table->string('nomatiere', 25);
            $table->string('nomprof', 25);
            $table->timestamps();
            $table->primary(['niveau', 'serie', 'codeclas', 'nomatiere']);

            // Définir une clé étrangère composite en utilisant `foreign`, `references` et `on`
            $table->foreign(['niveau', 'serie', 'codeclas'])
                ->references(['niveau', 'serie', 'codeclas'])
                ->on('classes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
