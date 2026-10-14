<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Bom;
use App\Models\DetailPenjualan;
use App\Models\Menu;
use App\Models\NotaJual;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaJualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notaJuals = NotaJual::with('user')->orderBy('id_nota_jual', 'desc')->get();
        return view('admin.nota-jual.index', ['notaJuals' => $notaJuals]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nota = new NotaJual();

        $nota->id_user = Auth::id();
        $nota->tanggal = request('tanggal');
        $nota->jenis = request('jenis');
        $nota->service_charge = 0;
        $nota->total = 0;
        $nota->created_at = now();

        $nota->save();

        return redirect()->route('admin.nota-jual.show', $nota->id_nota_jual);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notaJual = NotaJual::findOrFail($id);
        $detailPenjualans = DetailPenjualan::with('menu')->where('id_nota_jual', $id)->get();
        $menus = Menu::all();
        $isPaid = Pembayaran::where('id_nota_jual', $notaJual->id_nota_jual)->exists();

        return view('admin.nota-jual.show', [
            'notaJual' => $notaJual,
            'detailPenjualans' => $detailPenjualans,
            'menus' => $menus,
            'isPaid' => $isPaid,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotaJual $notaJual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotaJual $notaJual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotaJual $notaJual)
    {
        //
    }

    public function storeDetail(Request $request)
    {
        $id_nota_jual = $request->id_nota_jual;
        $totalTambahan = 0;

        // Jika tidak ada data array yang dikirim
        if (!$request->has('id_menus')) {
            return redirect()->back()->with('status', 'Keranjang masih kosong!');
        }

        // Looping sebanyak jumlah menu yang ada di list sementara kasir
        for ($i = 0; $i < count($request->id_menus); $i++) {

            $id_menu = $request->id_menus[$i];
            $qty = $request->qtys[$i];

            // Kalkulasi harga akurat dari database
            $menu = \App\Models\Menu::find($id_menu);
            $subtotal = $menu->harga_jual * $qty;

            // Simpan tiap barisnya ke database
            $detail = new \App\Models\DetailPenjualan();
            $detail->id_nota_jual = $id_nota_jual;
            $detail->id_menu = $id_menu;
            $detail->qty = $qty;
            $detail->harga_satuan = $menu->harga_jual;
            $detail->subtotal = $subtotal;
            $detail->save();

            $totalTambahan += $subtotal;
        }

        // Update Grand Total pada Nota Header
        $nota = NotaJual::find($id_nota_jual);
        $nota->total += $totalTambahan;
        $nota->save();

        return redirect()->back()->with('success', 'Semua pesanan berhasil disimpan ke database sekaligus!');
    }
    public function deleteDetail(Request $request)
    {
        $detail = DetailPenjualan::find($request->id);

        if ($detail) {
            // Kurangi Grand Total sebelum item dihapus
            $nota = NotaJual::find($detail->id_nota_jual);
            $nota->total -= $detail->subtotal;
            $nota->save();

            $detail->delete();
            return response()->json(['status' => 'oke', 'msg' => 'Item dihapus!'], 200);
        }
        return response()->json(['status' => 'error', 'msg' => 'Gagal menghapus'], 200);
    }

    public function checkout($id)
    {
        // 1. Tarik semua isi keranjang
        $details = DetailPenjualan::where('id_nota_jual', $id)->get();
        // 2. Looping setiap menu yang dibeli pelanggan (Misal: Nasi Goreng)
        foreach ($details as $detail) {
            $qty_terjual = $detail->qty; // Misal beli 2 porsi

            // 3. Cari resep (BOM) pembuat Nasi Goreng tersebut
            $boms = Bom::where('id_menu', $detail->id_menu)->get();

            // 4. Looping isi resepnya (Beras, Telur, Garam)
            foreach ($boms as $bom) {
                // Cari bahan bakunya di gudang
                $bahan = BahanBaku::find($bom->id_bahan);

                if ($bahan) {
                    // 5. RUMUS INTI: Pengurangan Stok Otomatis!
                    // Sisa Stok = Stok Lama - (Jumlah Beli x Takaran Resep)
                    $bahan->total_stok -= ($qty_terjual * $bom->jumlah_bahan);
                    $bahan->save();
                }
            }
        }
        // 6. Jika semua pemotongan stok selesai, kembalikan ke Halaman Riwayat Nota
        return redirect()->route('admin.nota-jual.index')->with('success', 'Transaksi Selesai! Stok Gudang berhasil dipotong otomatis sesuai resep BOM.');
    }

    public function saveBayar(Request $request)
    {
        $id = $request->id_nota_jual;

        // 1. KUNCI PERTAHANAN: Cek apakah sudah pernah dibayar (Cegah Double Click & Bug Minus Stok)
        $cekBayar = Pembayaran::where('id_nota_jual', $id)->first();
        if ($cekBayar) {
            return redirect()->back()->with('status', 'GAGAL! Transaksi ini sudah lunas sebelumnya.');
        }

        // 2. Simpan Bukti Pembayaran
        $bayar = new Pembayaran();
        $bayar->id_nota_jual = $id;
        $bayar->metode_bayar = $request->metode_bayar;
        $bayar->jumlah_bayar = $request->jumlah_bayar;
        $bayar->tanggal_bayar = date('Y-m-d H:i:s');
        $bayar->save();

        // 3. POTONG STOK GUDANG BERDASARKAN BOM
        $details = DetailPenjualan::where('id_nota_jual', $id)->get();
        foreach ($details as $detail) {
            $boms = Bom::where('id_menu', $detail->id_menu)->get();
            foreach ($boms as $bom) {
                $bahan = BahanBaku::find($bom->id_bahan);
                if ($bahan) {
                    $bahan->total_stok -= ($detail->qty * $bom->jumlah_bahan);
                    $bahan->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Pembayaran Berhasil! Stok bahan baku telah terpotong secara otomatis.');
    }
}
