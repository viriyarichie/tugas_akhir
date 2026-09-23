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
            'email' => 'admin@resto.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::create([
            'nama' => 'Manajer Operasional',
            'email' => 'manajer@resto.com',
            'password' => Hash::make('password'),
            'role' => 'manajer',
        ]);
        User::create([
            'nama' => 'Kasir 1',
            'email' => 'kasir@resto.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        // 2. Satuan
        $satuans = [
            ['nama' => 'gram'],
            ['nama' => 'ml'],
            ['nama' => 'kg'],
            ['nama' => 'liter'],
            ['nama' => 'pcs'],
        ];
        foreach ($satuans as $s) Satuan::create($s);

        // 3. Supplier
        Supplier::create(['nama' => 'Pasar Tradisional', 'kontak' => '-', 'lead_time' => 1]);
        Supplier::create(['nama' => 'PT Daging Sapi Segar', 'kontak' => '08123456789', 'lead_time' => 3]);
        Supplier::create(['nama' => 'Distributor Sayur', 'kontak' => '08987654321', 'lead_time' => 2]);

        // 4. Kategori Menu
        $km1 = KategoriMenu::create(['nama' => 'Makanan Utama']);
        $km2 = KategoriMenu::create(['nama' => 'Minuman']);
        $km3 = KategoriMenu::create(['nama' => 'Cemilan']);

        // 5. Menu
        Menu::create(['nama' => 'Nasi Goreng Spesial', 'kategori_menu_id' => $km1->id, 'harga_jual' => 25000]);
        Menu::create(['nama' => 'Mie Goreng Seafood', 'kategori_menu_id' => $km1->id, 'harga_jual' => 30000]);
        Menu::create(['nama' => 'Es Teh Manis', 'kategori_menu_id' => $km2->id, 'harga_jual' => 5000]);
        Menu::create(['nama' => 'Jus Jeruk', 'kategori_menu_id' => $km2->id, 'harga_jual' => 12000]);
        Menu::create(['nama' => 'Kentang Goreng', 'kategori_menu_id' => $km3->id, 'harga_jual' => 15000]);
    }
}
