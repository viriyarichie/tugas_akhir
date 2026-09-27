<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public const UPDATED_AT = null; // created_at exists but no updated_at
    protected $fillable = ['nama_menu', 'kategori_menu_idkategori_menu', 'harga_jual', 'is_aktif'];

    public function kategoriMenu()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_menu_idkategori_menu');
    }
}
