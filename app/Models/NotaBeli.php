<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaBeli extends Model
{
    protected $table = 'nota_beli';
    protected $primaryKey = 'id_nota_beli';
    public $timestamps = false;
    protected $fillable = [
        'id_supplier',
        'id_user',
        'tanggal',
        'created_at'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_nota_beli');
    }

    public function pembayaranPembelian()
    {
        return $this->hasMany(PembayaranPembelian::class, 'id_nota_beli', 'id_nota_beli');
    }
}
