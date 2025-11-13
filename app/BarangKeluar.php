<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';
    protected $primaryKey = 'id_brg_keluar';
    public $timestamps = true;

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'tujuan',
        'keperluan',
        'tanggal',
        'user_id',
        'approved_by',
        'is_approved',
        'alasan',
    ];

    protected $casts = [
        'jumlah'      => 'integer',
        'tanggal'     => 'date',
        'is_approved' => 'boolean',
    ];
}
