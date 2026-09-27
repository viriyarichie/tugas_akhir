<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\KategoriMenu;
use App\Models\Menu;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. User
        User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::create([
            'nama' => 'Manajer Operasional',
            'email' => 'manajer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'manajer',
        ]);
        User::create([
            'nama' => 'Kasir 1',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        // 2. Satuan
        $satuans = [
            ['idsatuan' => 'GR', 'satuan' => 'gram'],
            ['idsatuan' => 'ML', 'satuan' => 'ml'],
            ['idsatuan' => 'KG', 'satuan' => 'kg'],
            ['idsatuan' => 'LTR', 'satuan' => 'liter'],
            ['idsatuan' => 'PCS', 'satuan' => 'pcs'],
        ];
        foreach ($satuans as $s) Satuan::create($s);

        // 3. Supplier
        Supplier::create(['nama_supplier' => 'Pasar Tradisional', 'kontak' => '-', 'alamat' => '-']);
        Supplier::create(['nama_supplier' => 'PT Daging Sapi Segar', 'kontak' => '08123456789', 'alamat' => 'Jl. Merdeka No 1']);
        Supplier::create(['nama_supplier' => 'Distributor Sayur', 'kontak' => '08987654321', 'alamat' => 'Pasar Induk']);

        // 4. Kategori Menu
        $km1 = KategoriMenu::create(['nama_kategori' => 'Makanan Utama']);
        $km2 = KategoriMenu::create(['nama_kategori' => 'Minuman']);
        $km3 = KategoriMenu::create(['nama_kategori' => 'Cemilan']);

        // 5. Menu
        Menu::create(['nama_menu' => 'Nasi Goreng Spesial', 'kategori_menu_idkategori_menu' => $km1->idkategori_menu, 'harga_jual' => 25000]);
        Menu::create(['nama_menu' => 'Mie Goreng Seafood', 'kategori_menu_idkategori_menu' => $km1->idkategori_menu, 'harga_jual' => 30000]);
        Menu::create(['nama_menu' => 'Es Teh Manis', 'kategori_menu_idkategori_menu' => $km2->idkategori_menu, 'harga_jual' => 5000]);
        Menu::create(['nama_menu' => 'Jus Jeruk', 'kategori_menu_idkategori_menu' => $km2->idkategori_menu, 'harga_jual' => 12000]);
        Menu::create(['nama_menu' => 'Kentang Goreng', 'kategori_menu_idkategori_menu' => $km3->idkategori_menu, 'harga_jual' => 15000]);
    }
}
