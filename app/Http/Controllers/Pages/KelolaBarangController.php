<?php

namespace App\Http\Controllers\Pages;

use App\BarangMasuk;
use Illuminate\Http\Request;
use App\Jobs\NotifyBarangApproved;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyBarangNotApproved;
use App\Jobs\NotifyBarangMasukCreated;

class KelolaBarangController extends Controller
{
    public function showBarangMasuk()
    {
        $link = "barangMasuk";
        $items = BarangMasuk::orderByDesc('tanggal')->get();
        return view('pages.BarangMasuk', compact('link', 'items'));
    }

    // Tambahan kirim email dan telegram admin jobs
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah'      => 'required|integer|min:1',
            'supplier'    => 'required|string|max:255',
        ]);

        $barang = BarangMasuk::create([
            'tanggal'     => $validated['tanggal'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah'      => $validated['jumlah'],
            'supplier'    => $validated['supplier'],
            'user_id'     => Auth::id(),
        ]);

        // dispatch job notifikasi
        NotifyBarangMasukCreated::dispatch($barang->id_brg_masuk);

        return back()->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    // Fungsi utamanya ketika button approved ditekan
    public function approve(Request $request, $id_brg_masuk)
    {
        // Wajib login & role admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bukan admin tidak boleh approved');
        }

        $barang = BarangMasuk::findOrFail($id_brg_masuk);

        // Panggil fungsi private yang terpisah
        [$ok, $msg] = $this->approveBarangMasuk($barang, Auth::id());

        // Jobs nootify approve
        if ($ok) {
            NotifyBarangApproved::dispatch($barang->id_brg_masuk, Auth::id());
        }

        return back()->with($ok ? 'success' : 'info', $msg);
    }

    private function approveBarangMasuk(BarangMasuk $barang, int $approverId): array
    {
        if ((int) $barang->is_approved === 1) {
            return [false, 'Barang ini sudah diapprove sebelumnya'];
        }

        $barang->approved_by = $approverId;
        $barang->is_approved = 1;
        $barang->save();

        return [true, 'Barang masuk berhasil diapprove'];
    }

    // Fungsi kedua ketika barang tidak approved
    public function notApprove(Request $request, $id_brg_masuk)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Bukan admin tidak boleh tidak approve');
        }

        $barang = BarangMasuk::findOrFail($id_brg_masuk);

        // Tambahan kolom alasan modal bootstrap ketika muncul
        $alasan = $request->input('alasan');

        [$ok, $msg] = $this->rejectBarangMasuk($barang, Auth::id(), $alasan);

        if ($ok) {
            NotifyBarangNotApproved::dispatch($barang->id_brg_masuk, Auth::id(), $alasan);
        }

        return back()->with($ok ? 'success' : 'info', $msg);
    }

    private function rejectBarangMasuk(BarangMasuk $barang, int $approverId, ?string $alasan = null): array
    {
        if ((int) $barang->is_approved === 2) {
            return [false, 'Barang ini sudah ditandai Tidak Approve sebelumnya'];
        }

        $barang->approved_by = $approverId;
        $barang->is_approved = 2;
        $barang->alasan      = $alasan;
        $barang->save();

        return [true, 'Barang masuk ditandai Tidak Approve'];
    }

    public function update(Request $request, $id_brg_masuk)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah'      => 'required|integer|min:1',
            'supplier'    => 'required|string|max:255',
        ]);

        $barang = BarangMasuk::findOrFail($id_brg_masuk);

        $barang->update([
            'tanggal'     => $validated['tanggal'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah'      => $validated['jumlah'],
            'supplier'    => $validated['supplier'],
        ]);

        // Kembali ke daftar
        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diperbarui.');
    }

    public function destroy($id_brg_masuk)
    {
        // Ambil data barang
        $items = BarangMasuk::findOrFail($id_brg_masuk);
        // Hapus data dari table utama
        $items->delete();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang berhasil dihapus.');
    }
}
