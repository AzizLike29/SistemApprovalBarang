<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            // PK
            $table->bigIncrements('id_brg_keluar');

            // DATA
            $table->string('nama_barang');
            $table->unsignedInteger('jumlah');
            $table->string('tujuan')->nullable();
            $table->string('keperluan')->nullable();
            $table->date('tanggal');

            // Relasi ke users (pakai PK users: id_users)
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('approved_by')->nullable();

            // Status approval
            $table->boolean('is_approved')->default(false);

            // Foreign keys
            $table->foreign('user_id')
                ->references('id_users')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('approved_by')
                ->references('id_users')->on('users')
                ->onUpdate('cascade')->onDelete('set null');

            $table->text('alasan')->nullable();

            // TIMESTAMPS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_keluar');
    }
}
