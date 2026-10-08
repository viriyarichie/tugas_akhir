<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPembelian extends Model
{
    protected $table = 'pembayaran_pembelian';
    protected $primaryKey = 'idpembayaran_pembelian';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_bayar',
        'id_nota_beli'
    ];

    public function notaBeli()
    {
        return $this->belongsTo(NotaBeli::class, 'id_nota_beli');
    }
}
