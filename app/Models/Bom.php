<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    protected $table = 'bom';
    protected $primaryKey = 'id_bom';
    public const UPDATED_AT = null; // created_at exists but no updated_at
    protected $fillable = ['id_menu', 'id_bahan', 'jumlah_bahan', 'idsatuan'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'idsatuan');
    }
}
