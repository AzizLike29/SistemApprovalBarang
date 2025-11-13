<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HistoryBarangController extends Controller
{
    public function historyBarang(Request $request)
    {
        $link = "historyBarang";

        // Query gabungan
        $logsQuery = $this->buildHistoryQuery();

        if ($request->filled('q')) {
            $q = '%' . $request->q . '%';
            $logsQuery->where(function ($w) use ($q) {
                $w->where('description', 'like', $q)
                    ->orWhere('user_nama', 'like', $q)
                    ->orWhere('action', 'like', $q)
                    ->orWhere('module', 'like', $q);
            });
        }

        $logs = $logsQuery
            ->orderByDesc('waktu')
            ->paginate(25)
            ->withQueryString();

        return view('pages.HistoryBarang', compact('link', 'logs'));
    }

    public function exportPdf()
    {
        $logs = $this->buildHistoryQuery()
            ->orderByDesc('waktu')
            ->get();

        // Kirim ke view PDF
        $pdf = Pdf::loadView('pages.DownloadPDF', compact('logs'))
            ->setPaper('a4', 'portrait'); // ukuran kertas A4 tegak

        return $pdf->download('Laporan_History_Barang_' . now()->format('Ymd_His') . '.pdf');
    }

    private function buildHistoryQuery()
    {
        // Barang Masuk - Create
        $bmCreate = DB::table('barang_masuk as bm')
            ->leftJoin('users as u', 'u.id_users', '=', 'bm.user_id')
            ->selectRaw("
                bm.created_at AS waktu,
                bm.user_id    AS user_id,
                COALESCE(u.nama,'System') AS user_nama,
                'create'      AS action,
                'barang_masuk' AS module,
                bm.id_brg_masuk AS ref_id,
                'success'     AS status,
                CONCAT('Input barang masuk: ', bm.nama_barang, ' (', bm.jumlah, ') dari ', COALESCE(bm.supplier,'-')) AS description,
                NULL          AS alasan
            ");

        // Barang Masuk - Approve
        $bmApprove = DB::table('barang_masuk as bm')
            ->leftJoin('users as u', 'u.id_users', '=', 'bm.approved_by')
            ->where('bm.is_approved', 1)
            ->whereNotNull('bm.approved_by')
            ->selectRaw("
                bm.updated_at AS waktu,
                bm.approved_by AS user_id,
                COALESCE(u.nama,'—') AS user_nama,
                'approve'      AS action,
                'barang_masuk' AS module,
                bm.id_brg_masuk AS ref_id,
                'success'      AS status,
                CONCAT('Approve barang masuk: ', bm.nama_barang, ' (', bm.jumlah, ')') AS description,
                NULL AS alasan
            ");

        // Barang Masuk - Reject
        $bmReject = DB::table('barang_masuk as bm')
            ->leftJoin('users as u', 'u.id_users', '=', 'bm.approved_by')
            ->where('bm.is_approved', 2)
            ->whereNotNull('bm.approved_by')
            ->selectRaw("
                bm.updated_at AS waktu,
                bm.approved_by AS user_id,
                COALESCE(u.nama,'—') AS user_nama,
                'reject'       AS action,
                'barang_masuk' AS module,
                bm.id_brg_masuk AS ref_id,
                'success'      AS status,
                CONCAT('Tidak approve barang masuk: ', bm.nama_barang, ' (', bm.jumlah, ')') AS description,
                bm.alasan AS alasan
            ");

        // Barang Keluar - Create
        $bkCreate = DB::table('barang_keluar as bk')
            ->leftJoin('users as u', 'u.id_users', '=', 'bk.user_id')
            ->selectRaw("
                bk.created_at AS waktu,
                bk.user_id    AS user_id,
                COALESCE(u.nama,'System') AS user_nama,
                'create'      AS action,
                'barang_keluar' AS module,
                bk.id_brg_keluar AS ref_id,
                'success'     AS status,
                CONCAT('Input barang keluar: ', bk.nama_barang, ' (', bk.jumlah, ') tujuan ', COALESCE(bk.tujuan,'-'), ' - ', COALESCE(bk.keperluan,'-')) AS description,
                NULL AS alasan
            ");

        // Barang Keluar - Approve
        $bkApprove = DB::table('barang_keluar as bk')
            ->leftJoin('users as u', 'u.id_users', '=', 'bk.approved_by')
            ->where('bk.is_approved', 1)
            ->whereNotNull('bk.approved_by')
            ->selectRaw("
                bk.updated_at AS waktu,
                bk.approved_by AS user_id,
                COALESCE(u.nama,'—') AS user_nama,
                'approve'       AS action,
                'barang_keluar' AS module,
                bk.id_brg_keluar AS ref_id,
                'success'       AS status,
                CONCAT('Approve barang keluar: ', bk.nama_barang, ' (', bk.jumlah, ')') AS description,
                NULL AS alasan
            ");

        // Barang Keluar - Reject
        $bkReject = DB::table('barang_keluar as bk')
            ->leftJoin('users as u', 'u.id_users', '=', 'bk.approved_by')
            ->where('bk.is_approved', 2)
            ->whereNotNull('bk.approved_by')
            ->selectRaw("
                bk.updated_at AS waktu,
                bk.approved_by AS user_id,
                COALESCE(u.nama,'—') AS user_nama,
                'reject'        AS action,
                'barang_keluar' AS module,
                bk.id_brg_keluar AS ref_id,
                'success'       AS status,
                CONCAT('Tidak approve barang keluar: ', bk.nama_barang, ' (', bk.jumlah, ')') AS description,
                bk.alasan AS alasan
            ");

        // Notifikasi - Email
        $nEmail = DB::table('notifikasi as n')
            ->selectRaw("
                COALESCE(n.email_sent_at, n.created_at) AS waktu,
                NULL AS user_id,
                'System' AS user_nama,
                'notify_email' AS action,
                'notifikasi'   AS module,
                n.ref_id       AS ref_id,
                CASE WHEN n.email_terkirim = 1 THEN 'success' ELSE 'failed' END AS status,
                CONCAT('Email notifikasi utk BarangMasuk #', n.ref_id) AS description,
                NULL AS alasan
            ")
            ->whereNotNull('n.email_terkirim');

        // 8) Notifikasi - Telegram
        $nTg = DB::table('notifikasi as n')
            ->selectRaw("
                COALESCE(n.telegram_sent_at, n.created_at) AS waktu,
                NULL AS user_id,
                'System' AS user_nama,
                'notify_telegram' AS action,
                'notifikasi'      AS module,
                n.ref_id          AS ref_id,
                CASE WHEN n.telegram_terkirim = 1 THEN 'success' ELSE 'failed' END AS status,
                CONCAT('Telegram notifikasi utk BarangMasuk #', n.ref_id) AS description,
                NULL AS alasan
            ")
            ->whereNotNull('n.telegram_terkirim');

        // Gabungkan semua SELECT dengan unionAll
        $union = $bmCreate
            ->unionAll($bmApprove)
            ->unionAll($bmReject)
            ->unionAll($bkCreate)
            ->unionAll($bkApprove)
            ->unionAll($bkReject)
            ->unionAll($nEmail)
            ->unionAll($nTg);

        // Bungkus union sebagai subquery supaya bisa di-order/paginate
        return DB::query()->fromSub($union, 'h');
    }
}
