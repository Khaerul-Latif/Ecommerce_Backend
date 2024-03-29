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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('nama')->unique()->nullable(false);
            $table->string('slug')->unique()->nullable(false);
            $table->text('deskripsi')->nullable(false);
            $table->string('dimension')->nullable(true);
            $table->string('berat')->nullable(true);
            $table->string('material')->nullable(true);
            $table->boolean('display')->nullable(false)->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // delete constrainr
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
        });
        Schema::dropIfExists('produk');
    }
};
