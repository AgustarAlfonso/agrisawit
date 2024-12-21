<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePanenTriggers extends Migration
{
    public function up()
    {
        // Trigger AFTER INSERT untuk tabel panen
        DB::unprepared('
            CREATE TRIGGER after_panen_insert
            AFTER INSERT ON panen
            FOR EACH ROW
            BEGIN
                INSERT INTO stok (jenisPerubahan, jumlahPerubahan, tanggalBerubah, panen_id)
                VALUES ("panen", NEW.jumlahPanen, NEW.tanggalPanen, NEW.id);
            END;
        ');

        // Trigger AFTER DELETE untuk tabel panen
        DB::unprepared('
            CREATE TRIGGER after_panen_delete
            AFTER DELETE ON panen
            FOR EACH ROW
            BEGIN
                DELETE FROM stok WHERE panen_id = OLD.id;
            END;
        ');

        // Trigger AFTER UPDATE untuk tabel panen
        DB::unprepared('
            CREATE TRIGGER after_panen_update
            AFTER UPDATE ON panen
            FOR EACH ROW
            BEGIN
                UPDATE stok
                SET jumlahPerubahan = NEW.jumlahPanen, tanggalBerubah = NEW.tanggalPanen
                WHERE panen_id = NEW.id;
            END;
        ');
    }

    public function down()
    {
        // Hapus trigger jika migrasi di-rollback
        DB::unprepared('DROP TRIGGER IF EXISTS after_panen_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_panen_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS after_panen_update');
    }
}
