<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bom;

class BomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Nasi Goreng Spesial (id_menu = 1)
        $bomNasiGoreng = [
            ['id_menu' => 1, 'id_bahan' => 1, 'jumlah_bahan' => 0.2, 'idsatuan' => 'KG'], // Beras
            ['id_menu' => 1, 'id_bahan' => 6, 'jumlah_bahan' => 1, 'idsatuan' => 'PCS'], // Telur
            ['id_menu' => 1, 'id_bahan' => 3, 'jumlah_bahan' => 0.1, 'idsatuan' => 'KG'], // Daging Ayam
            ['id_menu' => 1, 'id_bahan' => 7, 'jumlah_bahan' => 10, 'idsatuan' => 'GR'], // Bawang Merah
            ['id_menu' => 1, 'id_bahan' => 8, 'jumlah_bahan' => 5, 'idsatuan' => 'GR'], // Bawang Putih
            ['id_menu' => 1, 'id_bahan' => 9, 'jumlah_bahan' => 2, 'idsatuan' => 'GR'], // Garam
            ['id_menu' => 1, 'id_bahan' => 2, 'jumlah_bahan' => 0.05, 'idsatuan' => 'LTR'], // Minyak Goreng
        ];

        // 2. Mie Goreng Seafood (id_menu = 2)
        $bomMieGoreng = [
            ['id_menu' => 2, 'id_bahan' => 5, 'jumlah_bahan' => 0.1, 'idsatuan' => 'KG'], // Udang
            ['id_menu' => 2, 'id_bahan' => 6, 'jumlah_bahan' => 1, 'idsatuan' => 'PCS'], // Telur
            ['id_menu' => 2, 'id_bahan' => 7, 'jumlah_bahan' => 10, 'idsatuan' => 'GR'], // Bawang Merah
            ['id_menu' => 2, 'id_bahan' => 8, 'jumlah_bahan' => 5, 'idsatuan' => 'GR'], // Bawang Putih
            ['id_menu' => 2, 'id_bahan' => 2, 'jumlah_bahan' => 0.05, 'idsatuan' => 'LTR'], // Minyak Goreng
        ];

        // 3. Es Teh Manis (id_menu = 3)
        $bomEsTeh = [
            ['id_menu' => 3, 'id_bahan' => 11, 'jumlah_bahan' => 10, 'idsatuan' => 'GR'], // Teh
            ['id_menu' => 3, 'id_bahan' => 10, 'jumlah_bahan' => 20, 'idsatuan' => 'GR'], // Gula
            ['id_menu' => 3, 'id_bahan' => 14, 'jumlah_bahan' => 0.2, 'idsatuan' => 'KG'], // Es Batu
        ];

        // 4. Jus Jeruk (id_menu = 4)
        $bomJusJeruk = [
            ['id_menu' => 4, 'id_bahan' => 12, 'jumlah_bahan' => 0.2, 'idsatuan' => 'KG'], // Jeruk
            ['id_menu' => 4, 'id_bahan' => 10, 'jumlah_bahan' => 20, 'idsatuan' => 'GR'], // Gula
            ['id_menu' => 4, 'id_bahan' => 14, 'jumlah_bahan' => 0.2, 'idsatuan' => 'KG'], // Es Batu
        ];

        // 5. Kentang Goreng (id_menu = 5)
        $bomKentangGoreng = [
            ['id_menu' => 5, 'id_bahan' => 13, 'jumlah_bahan' => 0.2, 'idsatuan' => 'KG'], // Kentang
            ['id_menu' => 5, 'id_bahan' => 9, 'jumlah_bahan' => 5, 'idsatuan' => 'GR'], // Garam
            ['id_menu' => 5, 'id_bahan' => 2, 'jumlah_bahan' => 0.1, 'idsatuan' => 'LTR'], // Minyak Goreng
        ];

        $allBoms = array_merge($bomNasiGoreng, $bomMieGoreng, $bomEsTeh, $bomJusJeruk, $bomKentangGoreng);

        foreach ($allBoms as $bom) {
            Bom::create($bom);
        }
    }
}
