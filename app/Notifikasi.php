<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'ref_id'            => 'integer',
        'email_terkirim'    => 'boolean',
        'telegram_terkirim' => 'boolean',
        'email_sent_at'     => 'datetime',
        'telegram_sent_at'  => 'datetime',
        'created_at'        => 'datetime',
    ];
}
