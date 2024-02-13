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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('no_ticket', 100)->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('no_wa', 50)->nullable();
            $table->string('jenis_pengaduan', 60)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status', 30)->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
