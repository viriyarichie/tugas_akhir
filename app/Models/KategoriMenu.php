<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    protected $table = 'kategori_menu';
    protected $primaryKey = 'idkategori_menu';
    public $timestamps = false;
    protected $fillable = ['nama_kategori'];
    
    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_menu_idkategori_menu');
    }
}