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
        Schema::create('modelis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('marka', 15);
            $table->string('modelis', 30);
            $table->string('degvielas_tips', 10);
            $table->unsignedTinyInteger('vietu_skaits');
            $table->string('transmisija', 15);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelis');
    }
};
