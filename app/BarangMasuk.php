<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_brg_masuk';
    public $timestamps = true;

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'supplier',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id_users');
    }

    public function scopeLatestPerNamaBarang(Builder $query): Builder
    {
        // subquery untuk id terakhir per nama_barang
        $sub = DB::table('barang_masuk')
            ->select(DB::raw('MAX(id_brg_masuk) AS last_id'), 'nama_barang')
            ->groupBy('nama_barang');

        return $query
            ->select('barang_masuk.id_brg_masuk', 'barang_masuk.nama_barang', 'barang_masuk.jumlah')
            ->joinSub($sub, 'x', function ($join) {
                $join->on('x.last_id', '=', 'barang_masuk.id_brg_masuk');
            })
            ->orderBy('barang_masuk.nama_barang');
    }

    public static function opsiUntukBarangKeluar()
    {
        return static::latestPerNamaBarang()->get();
    }
}
