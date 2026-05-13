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
        Schema::create('lietotajs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vards', 20);
            $table->string('uzvards', 20);
            $table->string('pilns_vards', 40);
            $table->string('epasts', 50);
            $table->string('telefons', 30);
            $table->string('paroles_hash', 100);
            $table->string('vaditaja_apliecibas_nr', 10);
            $table->string('vaditaja_apliecibas_statuss', 10);
            $table->dateTime('vaditaja_apliecibas_termins');
            $table->dateTime('izveidots');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lietotajs');
    }
};
