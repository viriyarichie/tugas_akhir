<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Satuan;
use App\Models\KategoriMenu;


class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahanBakus = BahanBaku::all();
        $satuans = Satuan::all();

        return view('admin.bahan-baku.index', ['bahanBakus' => $bahanBakus, 'satuans' => $satuans]);
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
        $bahanBaku = new BahanBaku();
        $bahanBaku->nama_bahan = $request->input('nama_bahan');
        $bahanBaku->total_stok = $request->input('total_stok');
        $bahanBaku->idsatuan = $request->input('idsatuan');
        $bahanBaku->stok_onorder_customer = $request->input('stok_onorder_customer');
        $bahanBaku->stok_onorder_supplier = $request->input('stok_onorder_supplier');
        $bahanBaku->kategori = $request->input('kategori');
        $bahanBaku->save();

        return redirect()->route('admin.bahan-baku.index')->with('success', 'Bahan Baku created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $data = BahanBaku::find($id);
        $satuans = Satuan::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.bahan-baku.getEditForm', compact('data', 'satuans'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = BahanBaku::find($id);

        $data->nama_bahan = $request->nama_bahan;
        $data->total_stok = $request->total_stok;
        $data->idsatuan = $request->idsatuan;
        $data->stok_onorder_customer = $request->stok_onorder_customer;
        $data->stok_onorder_supplier = $request->stok_onorder_supplier;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Data Bahan Baku berhasil diperbarui!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        // $this->authorize('delete-permission', Auth::user()); // Sesuai project lama jika ada gate khusus delete

        $id = $request->id;
        $data = BahanBaku::find($id);

        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Bahan Baku <b>' . $data->nama_bahan . '</b> berhasil dihapus!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus! Pastikan kategori ini tidak sedang dipakai di tabel Menu.'
            ], 200);
        }
    }
}
