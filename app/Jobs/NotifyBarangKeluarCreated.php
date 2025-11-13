<?php

namespace App\Jobs;

use App\User;
use App\Notifikasi;
use App\BarangKeluar;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyBarangKeluarCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public int $id_brg_keluar;

    public function __construct(int $id_brg_keluar)
    {
        $this->id_brg_keluar = $id_brg_keluar;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $barang = BarangKeluar::find($this->id_brg_keluar);
        if (!$barang) return;

        $tglKeluar = optional($barang->tanggal)->format('Y-m-d') ?? '-';
        $textPesan = "Barang Keluar Baru\n"
            . "Tanggal : {$tglKeluar}\n"
            . "Nama : {$barang->nama_barang}\n"
            . "Jumlah : {$barang->jumlah}\n"
            . "tujuan : {$barang->tujuan}\n"
            . "keperluan : {$barang->keperluan}\n";

        $fromAddress = config('mail.from.address', env('MAIL_FROM_ADDRESS'));
        $fromName    = config('mail.from.name', env('MAIL_FROM_NAME', 'Sistem Approval Barang'));

        // Flag dan Timestamp hasil kirim
        $emailSent      = false;
        $telegramSent   = false;
        $emailSentAt    = null;
        $telegramSentAt = null;

        // Kirim email role user
        $roleAdmin = User::where('role', 'user')
            ->whereNotNull('email')
            ->get();

        // Cek log email apabila error
        if (empty($fromAddress)) {
            Log::warning('MAIL_FROM_ADDRESS tidak ditemukan saat job dieksekusi', [
                'env' => env('MAIL_FROM_ADDRESS'),
                'config' => config('mail.from.address')
            ]);
        } else {
            foreach ($roleAdmin as $admin) {
                $email = trim((string) $admin->email);
                if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    try {
                        Mail::raw($textPesan, function ($m) use ($admin, $email, $fromAddress, $fromName) {
                            $m->from($fromAddress, $fromName)
                                ->to($email, $admin->nama ?? null)
                                ->subject('Barang Keluar Baru');
                        });
                        // Jika tidak ada exception
                        if (!$emailSent) {
                            $emailSent = true;
                            $emailSentAt = now();
                        }
                    } catch (\Throwable $e) {
                        // Simpan log untuk mengetahui status
                        Log::error('Gagal kirim email', [
                            'to'    => $email,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }
        }

        // Kirim Telegram
        $token = env('TELEGRAM_BOT_TOKEN');
        $defaultChat = env('TELEGRAM_CHAT_ID');

        if ($token) {
            foreach ($roleAdmin as $user) {
                if (!empty($user->telegram_chat_id)) {
                    try {
                        $res = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                            'chat_id'    => $user->telegram_chat_id,
                            'text'       => $textPesan,
                            'parse_mode' => 'HTML',
                        ]);

                        if ($res->ok() && ($res->json('ok') === true)) {
                            if (!$telegramSent) {
                                $telegramSent   = true;
                                $telegramSentAt = now();
                            }
                        } else {
                            Log::error('Telegram API tidak OK', [
                                'to' => $user->telegram_chat_id,
                                'resp' => $res->body()
                            ]);
                        }
                    } catch (\Throwable $e) {
                        Log::error('Gagal kirim Telegram', [
                            'to' => $user->telegram_chat_id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }

            // Fallback jika user tidak punya telegram_chat_id
            if (!$telegramSent && !empty($defaultChat)) {
                try {
                    $res = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                        'chat_id'    => $defaultChat,
                        'text'       => $textPesan,
                        'parse_mode' => 'HTML',
                    ]);

                    if ($res->ok() && ($res->json('ok') === true)) {
                        $telegramSent   = true;
                        $telegramSentAt = $telegramSentAt = now();
                    } else {
                        Log::error('Telegram fallback gagal', [
                            'to' => $defaultChat,
                            'resp' => $res->body()
                        ]);
                    }
                } catch (\Throwable $e) {
                    Log::error('Gagal kirim Telegram (fallback)', [
                        'to' => $defaultChat,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            // Record table notifikasi
            try {
                Notifikasi::create([
                    'jenis'              => 'barang_keluar',
                    'ref_id'             => $barang->id_brg_keluar,
                    'email_terkirim'     => $emailSent,
                    'telegram_terkirim'  => $telegramSent,
                    'email_sent_at'      => $emailSentAt,
                    'telegram_sent_at'   => $telegramSentAt,
                ]);
            } catch (\Throwable $e) {
                Log::error('Gagal mencatat notifikasi', [
                    'ref_id' => $barang->id_brg_masuk,
                    'error'  => $e->getMessage(),
                ]);
            }
        }
    }
}
