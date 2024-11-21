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
        Schema::create('classes', function (Blueprint $table) {
            //$table->id();
            $table->string('niveau', 4);
            $table->string('serie', 4);
            $table->string('codeclas', 1);
            $table->string('periode', 2);
            $table->string('proftitul', 25);
            $table->primary(['niveau', 'serie', 'codeclas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
