<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Menambahkan kolom 'image' bertipe string dan nullable
            $table->string('image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Menghapus kolom 'image' jika migrasi dibatalkan
            $table->dropColumn('image');
        });
    }
};

