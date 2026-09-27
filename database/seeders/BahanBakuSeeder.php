<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Satuan reference berdasarkan MasterDataSeeder:
        // GR, ML, KG, LTR, PCS

        $bahan = [
            ['nama_bahan' => 'Beras', 'idsatuan' => 'KG', 'kategori' => 'utama', 'total_stok' => 50],
            ['nama_bahan' => 'Minyak Goreng', 'idsatuan' => 'LTR', 'kategori' => 'utama', 'total_stok' => 20],
            ['nama_bahan' => 'Daging Ayam', 'idsatuan' => 'KG', 'kategori' => 'utama', 'total_stok' => 15],
            ['nama_bahan' => 'Daging Sapi', 'idsatuan' => 'KG', 'kategori' => 'utama', 'total_stok' => 10],
            ['nama_bahan' => 'Udang', 'idsatuan' => 'KG', 'kategori' => 'utama', 'total_stok' => 5],
            ['nama_bahan' => 'Telur', 'idsatuan' => 'PCS', 'kategori' => 'utama', 'total_stok' => 100],
            ['nama_bahan' => 'Bawang Merah', 'idsatuan' => 'GR', 'kategori' => 'pendukung', 'total_stok' => 2000],
            ['nama_bahan' => 'Bawang Putih', 'idsatuan' => 'GR', 'kategori' => 'pendukung', 'total_stok' => 1500],
            ['nama_bahan' => 'Garam', 'idsatuan' => 'GR', 'kategori' => 'pendukung', 'total_stok' => 3000],
            ['nama_bahan' => 'Gula', 'idsatuan' => 'GR', 'kategori' => 'pendukung', 'total_stok' => 5000],
            ['nama_bahan' => 'Teh', 'idsatuan' => 'GR', 'kategori' => 'utama', 'total_stok' => 1000],
            ['nama_bahan' => 'Jeruk', 'idsatuan' => 'KG', 'kategori' => 'utama', 'total_stok' => 10],
            ['nama_bahan' => 'Kentang', 'idsatuan' => 'KG', 'kategori' => 'utama', 'total_stok' => 20],
            ['nama_bahan' => 'Es Batu', 'idsatuan' => 'KG', 'kategori' => 'pendukung', 'total_stok' => 15],
            ['nama_bahan' => 'Susu Kental Manis', 'idsatuan' => 'ML', 'kategori' => 'pendukung', 'total_stok' => 5000],
        ];

        foreach ($bahan as $b) {
            BahanBaku::create($b);
        }
    }
}
