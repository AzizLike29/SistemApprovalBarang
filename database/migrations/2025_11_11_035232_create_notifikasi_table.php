<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            // PK
            $table->bigIncrements('id_notifikasi');

            // DATA
            $table->enum('jenis', ['barang_masuk', 'barang_keluar']);
            $table->unsignedBigInteger('ref_id');

            // KIRIM NOTIFIKASI
            $table->boolean('email_terkirim')->default(false)->comment('1=terkirim, 0=belum');
            $table->boolean('telegram_terkirim')->default(false)->comment('1=terkirim, 0=belum');

            // DATETIME
            $table->dateTime('email_sent_at')->nullable();
            $table->dateTime('telegram_sent_at')->nullable();

            // LOOP INDEX
            $table->index(['jenis', 'ref_id']);

            // TIMESTAMPS CURRENT
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
}
