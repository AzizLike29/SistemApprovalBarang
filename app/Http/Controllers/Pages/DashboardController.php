<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $link = 'dashboard';

        $threshold = 5;

        // Total jenis barang (unik) dari gabungan masuk & keluar
        $unionNama = DB::table('barang_masuk')->select('nama_barang')
            ->union(DB::table('barang_keluar')->select('nama_barang'));

        $totalBarang = DB::query()
            ->fromSub($unionNama, 'u')
            ->distinct()
            ->count('nama_barang');

        // Hitung Approved / Belum / Tidak Approve untuk barang_masuk
        $belumApprove  = DB::table('barang_masuk')->where('is_approved', 0)->count();
        $sudahApprove  = DB::table('barang_masuk')->where('is_approved', 1)->count();
        $tidakApprove  = DB::table('barang_masuk')->where('is_approved', 2)->count();

        // Snapshot stok (sisa = total masuk - total keluar) per nama_barang
        $masukSub = DB::table('barang_masuk')
            ->select('nama_barang', DB::raw('SUM(jumlah) as total_masuk'))
            ->groupBy('nama_barang');

        $keluarSub = DB::table('barang_keluar')
            ->select('nama_barang', DB::raw('SUM(jumlah) as total_keluar'))
            ->groupBy('nama_barang');

        $saldoPerItem = DB::query()
            ->fromSub($masukSub, 'm')
            ->leftJoinSub($keluarSub, 'k', 'k.nama_barang', '=', 'm.nama_barang')
            ->select(
                'm.nama_barang',
                DB::raw('m.total_masuk - COALESCE(k.total_keluar, 0) as sisa')
            )
            ->get();

        // Total stok tersisa (akumulasi semua item)
        $totalSisa = (int) $saldoPerItem->sum('sisa');

        // Jumlah item yang stoknya menipis (<= threshold)
        $stokMenipis = $saldoPerItem->where('sisa', '<=', $threshold)->count();

        return view('pages.Dashboard', compact(
            'link',
            'totalBarang',
            'belumApprove',
            'sudahApprove',
            'stokMenipis',
            'totalSisa',
            'tidakApprove',
            'saldoPerItem'
        ));
    }
}
