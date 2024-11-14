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

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_id'); // Fremdschlüssel zu Data-Tabelle
            $table->string('file_path');
            $table->integer('sort')->default(0);
            $table->timestamps();

            // Fremdschlüsselbeziehung
            $table->foreign('data_id')->references('id')->on('data')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
