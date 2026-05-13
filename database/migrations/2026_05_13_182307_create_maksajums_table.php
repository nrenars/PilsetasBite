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
        Schema::create('maksajums', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('summa_bez_pvn', 10, 2);
            $table->decimal('summa_ar_pvn', 10, 2);
            $table->string('maksajuma_veids', 20);
            $table->string('maksajuma_statuss', 20);
            $table->dateTime('maksajuma_datums');

            $table->foreignId('ire_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maksajums');
    }
};
