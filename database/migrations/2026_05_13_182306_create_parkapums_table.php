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
        Schema::create('parkapums', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('apraksts');
            $table->decimal('summa', 10, 2);
            $table->string('tips', 30);
            $table->string('statuss', 10);
            $table->foreignId('lietotajs_id')->constrained()->onDelete('cascade');
            $table->foreignId('ire_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkapums');
    }
};
