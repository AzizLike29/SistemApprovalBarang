<?php

namespace App\Http\Controllers\Pages;

use App\BarangMasuk;
use App\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyBarangKeluarCreated;
use App\Jobs\NotifyBarangKeluarApproved;
use App\Jobs\NotifyBarangOutNotApproved;

class KelolaBarangKeluarController extends Controller
{
    public function showBarangKeluar()
    {
        $opsiBarangMasuk = BarangMasuk::opsiUntukBarangKeluar();
        $items = BarangKeluar::orderByDesc('tanggal')->get();
        $link = "barangKeluar";
        return view('pages.BarangKeluar', compact('link', 'opsiBarangMasuk', 'items'));
    }

    // Tambahan kirim email dan telegram admin jobs
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah'      => 'required|integer|min:1',
            'tujuan'      => 'required|string|max:255',
            'keperluan'   => 'required|string|max:255',
        ]);

        $barang = BarangKeluar::create([
            'tanggal'     => $validated['tanggal'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah'      => $validated['jumlah'],
            'tujuan'      => $validated['tujuan'],
            'keperluan'   => $validated['keperluan'],
            'user_id'     => Auth::id(),
        ]);

        // dispatch job notifikasi
        NotifyBarangKeluarCreated::dispatch($barang->id_brg_keluar);

        return back()->with('success', 'Barang keluar berhasil ditambahkan.');
    }

    // Fungsi utamanya ketika button approved ditekan
    public function approve(Request $request, $id_brg_keluar)
    {
        // Wajib login & role admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bukan admin tidak boleh approved');
        }

        $barang = BarangKeluar::findOrFail($id_brg_keluar);

        // Panggil fungsi private yang terpisah
        [$ok, $msg] = $this->approveBarangKeluar($barang, Auth::id());

        // Jobs nootify approve
        if ($ok) {
            NotifyBarangKeluarApproved::dispatch($barang->id_brg_keluar, Auth::id());
        }

        return back()->with($ok ? 'success' : 'info', $msg);
    }

    private function approveBarangKeluar(BarangKeluar $barang, int $approverId): array
    {
        if ((int) $barang->is_approved === 1) {
            return [false, 'Barang ini sudah diapprove sebelumnya'];
        }

        $barang->approved_by = $approverId;
        $barang->is_approved = 1;
        $barang->save();

        return [true, 'Barang keluar berhasil diapprove'];
    }

    // Fungsi kedua ketika barang tidak approved
    public function notApprove(Request $request, $id_brg_keluar)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bukan admin tidak boleh tidak approve');
        }

        $barang = BarangKeluar::findOrFail($id_brg_keluar);

        // Tambahan kolom alasan modal bootstrap ketika muncul
        $alasan = $request->input('alasan');

        [$ok, $msg] = $this->rejectBarangKeluar($barang, Auth::id(), $alasan);

        if ($ok) {
            NotifyBarangOutNotApproved::dispatch($barang->id_brg_keluar, Auth::id(), $alasan);
        }

        return back()->with($ok ? 'success' : 'info', $msg);
    }

    private function rejectBarangKeluar(BarangKeluar $barang, int $approverId, ?string $alasan = null): array
    {
        if ((int) $barang->is_approved === 2) {
            return [false, 'Barang ini sudah ditandai Tidak Approve sebelumnya'];
        }

        $barang->approved_by = $approverId;
        $barang->is_approved = 2;
        $barang->save();

        return [true, 'Barang keluar ditandai Tidak Approve'];
    }

    public function update(Request $request, $id_brg_keluar)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah'      => 'required|integer|min:1',
            'tujuan'      => 'required|string|max:255',
            'keperluan'   => 'required|string|max:255',
        ]);

        $barang = BarangKeluar::findOrFail($id_brg_keluar);

        $barang->update([
            'tanggal'     => $validated['tanggal'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah'      => $validated['jumlah'],
            'tujuan'      => $validated['tujuan'],
            'keperluan'   => $validated['keperluan'],
        ]);

        // Kembali ke daftar
        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diperbarui.');
    }

    public function destroy($id_brg_keluar)
    {
        // Ambil data barang
        $items = BarangKeluar::findOrFail($id_brg_keluar);
        // Hapus data dari table utama
        $items->delete();

        return redirect()->route('barang-keluar.index')->with('success', 'Data barang berhasil dihapus.');
    }
}
