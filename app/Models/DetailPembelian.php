<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'id_detail_pembelian';
    public $timestamps = false;
    protected $fillable = [
        'id_nota_beli',
        'id_bahan',
        'jumlah_pesan',
        'harga_total'
    ];

    public function notaBeli()
    {
        return $this->belongsTo(NotaBeli::class, 'id_nota_beli');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan');
    }

    public function penerimaanBarang()
    {
        return $this->hasMany(PenerimaanBarang::class, 'id_detail_pembelian');
    }
}
