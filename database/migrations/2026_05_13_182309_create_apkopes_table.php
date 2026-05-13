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
        Schema::create('apkopes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('apraksts');
            $table->dateTime('datums');
            $table->decimal('izmaksas', 10, 2);
            $table->string('statuss', 10);
            $table->foreignId('masina_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apkopes');
    }
};
