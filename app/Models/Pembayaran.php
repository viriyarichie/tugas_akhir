<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;
    protected $fillable = [
        'id_nota_jual',
        'metode_bayar',
        'jumlah_bayar',
        'tanggal_bayar'
    ];
}
