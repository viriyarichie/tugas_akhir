<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;
use App\Models\NotaBeli;
use App\Models\PembayaranPembelian;
use App\Models\PenerimaanBarang;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class NotaBeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notaBelis = NotaBeli::all();
        $suppliers = Supplier::all();

        return view('admin.nota-beli.index', ['notaBelis' => $notaBelis, 'suppliers' => $suppliers]);
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
        $notaBeli = new NotaBeli();
        $notaBeli->id_supplier = $request->input('id_supplier');
        $notaBeli->id_user = Auth::id();
        $notaBeli->tanggal = $request->tanggal;
        $notaBeli->created_at = now();

        $notaBeli->save();

        return redirect()->route('admin.nota-beli.show', $notaBeli->id_nota_beli)->with('success', 'Nota Beli created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notaBeli = NotaBeli::findOrFail($id);
        $detailPembelians = DetailPembelian::where('id_nota_beli', $id)->get();
        $bahanBakus = BahanBaku::whereNotIn('id_bahan', function ($query) use ($id) {
            $query->select('id_bahan')
                ->from('detail_pembelian')
                ->where('id_nota_beli', $id);
        })->get();


        return view('admin.nota-beli.show', ['notaBeli' => $notaBeli, 'detailPembelians' => $detailPembelians, 'bahanBakus' => $bahanBakus]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getEditForm(Request $request)
    {
        $id = $request->id;
        $data = NotaBeli::find($id);
        $suppliers = Supplier::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.nota-beli.getEditForm', compact('data', 'suppliers'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = NotaBeli::find($id);

        $data->tanggal = $request->tanggal;
        $data->id_supplier = $request->id_supplier;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Data Nota Beli berhasil diperbarui!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        // $this->authorize('delete-permission', Auth::user()); // Sesuai project lama jika ada gate khusus delete

        $id = $request->id;
        $data = NotaBeli::find($id);

        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Nota Beli <b>' . $data->id_nota_beli . '</b> berhasil dihapus!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus! Pastikan kategori ini tidak sedang dipakai di tabel Menu.'
            ], 200);
        }
    }

    public function storeDetail(Request $request)
    {
        $detail = new DetailPembelian();
        $detail->id_nota_beli = $request->id_nota_beli;
        $detail->id_bahan = $request->id_bahan;
        $detail->jumlah_pesan = $request->jumlah_pesan;
        $detail->harga_total = $request->harga_total;
        $detail->save();
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke dalam nota.');
    }

    public function getEditFormDetail(Request $request)
    {
        $id = $request->id;
        $data = DetailPembelian::with('bahanBaku')->find($id);
        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.nota-beli.getEditFormDetail', compact('data'))->render()
        ], 200);
    }
    public function saveDataUpdateDetail(Request $request)
    {
        $id = $request->id;
        $data = DetailPembelian::find($id);
        $data->jumlah_pesan = $request->jumlah;
        $data->harga_total = $request->harga_total;
        $data->save();
        return response()->json([
            'status' => 'oke',
            'msg' => 'Detail pemesanan berhasil diperbarui!'
        ], 200);
    }
    public function deleteDataDetail(Request $request)
    {
        $id = $request->id;
        $data = DetailPembelian::find($id);
        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Barang berhasil dihapus dari nota!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus data barang.'
            ], 200);
        }
    }

    public function getTerimaBarangForm(Request $request)
    {
        $id = $request->id;
        $data = DetailPembelian::with('bahanBaku')->find($id);
        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.nota-beli.getTerimaBarangForm', compact('data'))->render()
        ], 200);
    }

    public function saveTerimaBarang(Request $request)
    {
        $detailPembelian = DetailPembelian::find($request->id_detail_pembelian);

        $totalDiterimaSebelumnya = PenerimaanBarang::where('id_detail_pembelian', $request->id_detail_pembelian)->sum('jumlah_diterima');

        $sisaBolehDiterima = $detailPembelian->jumlah_pesan - $totalDiterimaSebelumnya;

        if ($request->jumlah_diterima > $sisaBolehDiterima) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal terima barang! Sisa pesanan hanya adalah ' . $sisaBolehDiterima . ' barang.'
            ], 200);
        }

        $penerimaan = new PenerimaanBarang();
        $penerimaan->id_detail_pembelian = $request->id_detail_pembelian;
        $penerimaan->tanggal_terima = $request->tanggal_terima;
        $penerimaan->jumlah_diterima = $request->jumlah_diterima;
        $penerimaan->keterangan = $request->keterangan;
        $penerimaan->save();

        $bahanBaku = BahanBaku::find($detailPembelian->id_bahan);
        $bahanBaku->total_stok += $request->jumlah_diterima;
        $bahanBaku->save();

        $totalDiterimaBaru = $totalDiterimaSebelumnya + $request->jumlah_diterima;
        $status = "";
        $isLengkap = false;

        if ($totalDiterimaBaru >= $detailPembelian->jumlah_pesan) {
            $status = '<span class="badge bg-success">Selesai</span>';
            $isLengkap = true;
        } elseif ($totalDiterimaBaru > 0) {
            $status = '<span class="badge bg-warning text-dark">Sebagian (' . $totalDiterimaBaru . ')</span>';
        } else {
            $status = '<span class="badge bg-danger">Belum Diterima</span>';
        }

        return response()->json([
            'status' => 'oke',
            'msg' => 'Data penerimaan barang berhasil disimpan!',
            'statusTerima' => $status,
            'isLengkap' => $isLengkap
        ], 200);
    }

    public function getBayarForm(Request $request)
    {
        $nota = NotaBeli::find($request->id);

        $grandTotal = $nota->detailPembelian->sum('harga_total');
        $terbayar = $nota->pembayaranPembelian->sum('jumlah_bayar');
        $sisa = $grandTotal - $terbayar;

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.nota-beli.getBayarForm', compact('nota', 'grandTotal', 'terbayar', 'sisa'))->render()
        ], 200);
    }

    public function saveBayar(Request $request)
    {
        $nota = NotaBeli::find($request->id_nota_beli);
        $grandTotal = $nota->detailPembelian->sum('harga_total');
        $terbayar = $nota->pembayaranPembelian->sum('jumlah_bayar');
        $sisa = $grandTotal - $terbayar;

        if ($request->jumlah_bayar > $sisa) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal! Jumlah bayar (Rp ' . number_format($request->jumlah_bayar, 0, ',', '.') . ') melebihi sisa tagihan (Rp ' . number_format($sisa, 0, ',', '.') . ').'
            ], 200);
        }

        $bayar = new PembayaranPembelian();
        $bayar->id_nota_beli = $request->id_nota_beli;
        $bayar->tanggal_bayar = $request->tanggal_bayar;
        $bayar->jumlah_bayar = $request->jumlah_bayar;
        $bayar->metode_bayar = $request->metode_bayar;
        $bayar->save();

        $terbayarBaru = $terbayar + $request->jumlah_bayar;
        $isLunas = false;
        $statusHtml = "";

        if ($grandTotal == 0) {
            $statusHtml = '<span class="badge bg-secondary">Nota kosong</span>';
        } elseif ($terbayarBaru >= $grandTotal) {
            $statusHtml = '<span class="badge bg-success">Lunas</span>';
            $isLunas = true;
        } else {
            $statusHtml = '<span class="badge bg-warning text-dark">Hutang</span>';
        }

        return response()->json([
            'status' => 'oke',
            'msg' => 'Pembayaran berhasil dicatat!',
            'statusHtml' => $statusHtml,
            'isLunas' => $isLunas
        ], 200);
    }
}
