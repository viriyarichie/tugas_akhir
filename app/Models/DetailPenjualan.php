<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_detail_jual';
    public $timestamps = false;
    protected $fillable = [
        'id_nota_jual',
        'id_menu',
        'qty',
        'harga_satuan',
        'subtotal'
    ];

    public function notaJual()
    {
        return $this->belongsTo(NotaJual::class, 'id_nota_jual', 'id_nota_jual');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }
}
