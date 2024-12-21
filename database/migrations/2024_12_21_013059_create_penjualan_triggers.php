<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTriggers extends Migration
{
    public function up()
    {
        // Trigger AFTER INSERT untuk tabel penjualan
        DB::unprepared('
            CREATE TRIGGER after_penjualan_insert
            AFTER INSERT ON penjualan
            FOR EACH ROW
            BEGIN
                INSERT INTO stok (jenisPerubahan, jumlahPerubahan, tanggalBerubah, penjualan_id)
                VALUES ("penjualan", -NEW.jumlahTerjual, NEW.tanggalPenjualan, NEW.id);
            END;
        ');

        // Trigger AFTER DELETE untuk tabel penjualan
        DB::unprepared('
            CREATE TRIGGER after_penjualan_delete
            AFTER DELETE ON penjualan
            FOR EACH ROW
            BEGIN
                DELETE FROM stok WHERE penjualan_id = OLD.id;
            END;
        ');

        // Trigger AFTER UPDATE untuk tabel penjualan
        DB::unprepared('
            CREATE TRIGGER after_penjualan_update
            AFTER UPDATE ON penjualan
            FOR EACH ROW
            BEGIN
                UPDATE stok
                SET jumlahPerubahan = -NEW.jumlahTerjual, tanggalBerubah = NEW.tanggalPenjualan
                WHERE penjualan_id = NEW.id;
            END;
        ');
    }

    public function down()
    {
        // Hapus trigger jika migrasi di-rollback
        DB::unprepared('DROP TRIGGER IF EXISTS after_penjualan_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_penjualan_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS after_penjualan_update');
    }
}

