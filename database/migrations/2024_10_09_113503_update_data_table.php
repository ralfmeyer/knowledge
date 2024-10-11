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
        Schema::table('data', function (Blueprint $table) {
            // Entferne das Feld 'datum'
            $table->dropColumn('datum');

            // Füge die neuen Felder 'berechtigung' und 'userid' hinzu
            $table->integer('berechtigung')->default(0);
            $table->integer('userid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data', function (Blueprint $table) {
            // Füge das 'datum' Feld wieder hinzu
            $table->dateTime('datum')->nullable();

            // Entferne die Felder 'berechtigung' und 'userid'
            $table->dropColumn(['berechtigung', 'userid']);
        });
    }
};
