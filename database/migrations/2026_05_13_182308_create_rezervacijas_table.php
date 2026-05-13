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
        Schema::create('rezervacijas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('datums');
            $table->dateTime('deriguma_beigas');
            $table->string('statuss', 15);
            $table->foreignId('lietotajs_id')->constrained()->onDelete('cascade');
            $table->foreignId('masina_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rezervacijas');
    }
};
