<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bom;
use App\Models\Menu;
use App\Models\BahanBaku;
use App\Models\Satuan;

class BomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boms = Bom::all();
        return view('admin.bom.index', compact('boms'));
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
        $bom = new Bom();
        $bom->id_menu = $request->id_menu;
        $bom->id_bahan = $request->id_bahan;
        $bom->jumlah_bahan = $request->jumlah_bahan;

        // Otomatis tarik satuan dari master Bahan Baku (Solusi 1)
        $bahan = BahanBaku::find($request->id_bahan);
        $bom->idsatuan = $bahan->idsatuan;

        $bom->save();

        return redirect()->route('admin.bom.show', $request->id_menu)->with('success', 'Bahan berhasil ditambahkan ke resep.');
    }

    public function show(string $id)
    {
        $selectedMenu = Menu::findOrFail($id);
        $boms = Bom::where('id_menu', $id)->get();

        $bahanBakus = BahanBaku::whereNotIn('id_bahan', function ($query) use ($id) {
            $query->select('id_bahan')
                ->from('bom')
                ->where('id_menu', $id);
        })->get();

        $satuans = Satuan::all();

        return view('admin.bom.show', compact('selectedMenu', 'boms', 'bahanBakus', 'satuans'));
    }

    public function getEditForm(Request $request)
    {
        $id = $request->id;
        $data = Bom::find($id);

        // Ambil ID bahan yang sudah dipakai di resep ini (kecuali bahan yang sedang diedit ini)
        $usedBahanIds = Bom::where('id_menu', $data->id_menu)
            ->where('id_bahan', '!=', $data->id_bahan)
            ->pluck('id_bahan')
            ->toArray();

        // Tarik bahan baku yang tersedia
        $bahanBakus = BahanBaku::whereNotIn('id_bahan', $usedBahanIds)->get();

        $satuans = Satuan::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.bom.getEditForm', compact('data', 'bahanBakus', 'satuans'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Bom::find($id);

        $data->jumlah_bahan = $request->jumlah_bahan;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Bahan resep berhasil diperbarui!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Bom::find($id);

        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Bahan resep berhasil dihapus!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus bahan resep!'
            ], 200);
        }
    }
}
