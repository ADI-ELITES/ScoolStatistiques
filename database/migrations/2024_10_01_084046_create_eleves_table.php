<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matric', 30);
            $table->string('nom', 25);
            $table->string('prenom', 25);
            $table->string('sexe', 1);
            $table->date('datenais');
            $table->string('phoneeleve', 15);
            $table->string('nompar', 100);
            $table->string('prenpar', 100);
            $table->string('profespar', 50); // 20
            $table->string('phonepar', 15);
            $table->string('sexepar', 1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
