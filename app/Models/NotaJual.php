<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaJual extends Model
{
    protected $table = 'nota_jual';
    protected $primaryKey = 'id_nota_jual';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'tanggal',
        'jenis',
        'service_charge',
        'total',
        'created_at',
        'event_idevent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_nota_jual', 'id_nota_jual');
    }
}
