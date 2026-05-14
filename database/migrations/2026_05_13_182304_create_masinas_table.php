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
        Schema::create('masinas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('registracijas_nr', 8);
            $table->unsignedSmallInteger('gads');
            $table->unsignedTinyInteger('degvielas_limenis')->nullable();
            $table->unsignedTinyInteger('baterijas_limenis')->nullable();
            $table->string('statuss', 10);
            $table->dateTime('tehniskas_apskates_termins');

            $table->foreignId('modelis_id')->constrained()->onDelete('cascade');
            $table->foreignId('lokacija_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masinas');
    }
};
