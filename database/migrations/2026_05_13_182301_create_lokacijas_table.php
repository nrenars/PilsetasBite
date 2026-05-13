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
        Schema::create('lokacijas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('platuma_gradi');
            $table->float('garuma_gradi');
            $table->string('adrese');
            $table->string('pilseta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokacijas');
    }
};
