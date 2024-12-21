<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('stok', function (Blueprint $table) {
            $table->dropColumn('totalStok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('stok', function (Blueprint $table) {
            $table->integer('totalStok');
        });
    }
};
