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
        Schema::create('ires', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('sakuma_laiks');
            $table->dateTime('beigu_laiks')->nullable();
            $table->decimal('nobrauktais_attalums', 9, 3);
            $table->string('statuss', 15);
            $table->decimal('cena', 10, 2);
            $table->foreignId('lietotajs_id')->constrained()->onDelete('cascade');
            $table->foreignId('masina_id')->constrained()->onDelete('cascade');
            $table->foreignId('lokacija_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ires');
    }
};
