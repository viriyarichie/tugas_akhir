<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';
    protected $primaryKey = 'id_bahan';
    public const UPDATED_AT = null;
    protected $fillable = ['nama_bahan', 'total_stok', 'idsatuan', 'stok_onorder_customer', 'stok_onorder_supplier', 'kategori'];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'idsatuan');
    }
}
