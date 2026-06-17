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
        Schema::table('lietotajs', function (Blueprint $table) {
            $table->string('vaditaja_apliecibas_attels')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('lietotajs', function (Blueprint $table) {
            $table->dropColumn('vaditaja_apliecibas_attels');
        });
    }
};
