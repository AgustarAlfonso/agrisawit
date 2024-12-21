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
            Schema::create('stok', function (Blueprint $table) {
                $table->id();
                $table->string('jenisPerubahan'); // contoh: "panen", "penjualan"
                $table->integer('jumlahPerubahan'); // nilai positif untuk panen, negatif untuk penjualan
                $table->integer('totalStok'); // stok setelah perubahan
                $table->timestamp('tanggalBerubah')->useCurrent(); // tanggal perubahan
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
