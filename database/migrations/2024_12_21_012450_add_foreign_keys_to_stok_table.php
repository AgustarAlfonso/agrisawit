<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToStokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stok', function (Blueprint $table) {
            // Tambahkan kolom foreign key
            $table->foreignId('penjualan_id')->nullable()->after('tanggalBerubah')->constrained('penjualan')->onDelete('cascade');
            $table->foreignId('panen_id')->nullable()->after('penjualan_id')->constrained('panen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stok', function (Blueprint $table) {
            // Hapus foreign key dan kolom
            $table->dropForeign(['penjualan_id']);
            $table->dropColumn('penjualan_id');

            $table->dropForeign(['panen_id']);
            $table->dropColumn('panen_id');
        });
    }
}
