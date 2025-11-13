<?php

namespace App\Jobs;

use App\User;
use App\BarangMasuk;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyBarangApproved implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public int $id_brg_masuk;
    public int $approver_id;

    public function __construct(int $id_brg_masuk, int $approver_id)
    {
        $this->id_brg_masuk = $id_brg_masuk;
        $this->approver_id = $approver_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $barang = BarangMasuk::find($this->id_brg_masuk);
        $approver = User::find($this->approver_id);

        // return barang tidak ada
        if (!$barang) return;

        $namaApprover = $approver->nama ?? ('ID: ' . $this->approver_id);
        $textPesan = "Barang Masuk Disetujui\n"
            . "ID : {$barang->id_brg_masuk}\n"
            . "Nama : {$barang->nama_barang}\n"
            . "Jumlah : {$barang->jumlah}\n"
            . "Supplier : {$barang->supplier}\n"
            . "Approver : {$namaApprover}\n";

        $fromAddress = config('mail.from.address', env('MAIL_FROM_ADDRESS'));
        $fromName    = config('mail.from.name', env('MAIL_FROM_NAME', 'Sistem Approval Barang'));

        // Cek log address null
        if (empty($fromAddress)) {
            Log::warning('MAIL_FROM_ADDRESS tidak ditemukan saat job dieksekusi', [
                'env' => env('MAIL_FROM_ADDRESS'),
                'config' => config('mail.from.address')
            ]);
            return;
        }

        // Kirim email role user
        $roleAdmin = User::where('role', 'admin')
            ->whereNotNull('email')
            ->get();

        foreach ($roleAdmin as $admin) {
            $email = trim((string) $admin->email);
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::raw($textPesan, function ($m) use ($admin, $email, $fromAddress, $fromName) {
                    $m->from($fromAddress, $fromName)
                        ->to($email, $admin->nama ?? null)
                        ->subject('Barang Masuk Approved');
                });
            }
        }

        // Kirim Telegram
        $token = env('TELEGRAM_BOT_TOKEN');
        $defaultChat = env('TELEGRAM_CHAT_ID');

        if ($token) {
            foreach ($roleAdmin as $user) {
                if (!empty($user->telegram_chat_id)) {
                    Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                        'chat_id'    => $user->telegram_chat_id,
                        'text'       => $textPesan,
                        'parse_mode' => 'HTML',
                    ]);
                }
            }

            // Cek Log
            Log::info('Mengirim pesan ke Telegram:', [
                'token' => $token,
                'to'    => $user->telegram_chat_id ?? $defaultChat,
                'text'  => $textPesan
            ]);

            // Fallback jika user tidak punya telegram_chat_id
            if (!empty($defaultChat)) {
                Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id'    => $defaultChat,
                    'text'       => $textPesan,
                    'parse_mode' => 'HTML',
                ]);
            }
        }
    }
}
