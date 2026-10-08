<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    protected $table = 'penerimaan_barang';
    protected $primaryKey = 'id_penerimaan';
    public $timestamps = false;
    protected $fillable = [
        'id_detail_pembelian',
        'tanggal_terima',
        'jumlah_diterima',
        'keterangan'
    ];

    public function detailPembelian()
    {
        return $this->belongsTo(DetailPembelian::class, 'id_detail_pembelian');
    }
}
