<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;


class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $satuans = Satuan::all();
        return view('admin.satuan.index', ['satuans' => $satuans]);
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
        $satuan = new Satuan();
        $satuan->nama = $request->input('nama');

        $satuan->save();

        return redirect()->route('admin.satuan.index')->with('success', 'Satuan created successfully.');
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

    public function getEditForm(Request $request)
    {
        $id = $request->id;
        $data = Satuan::find($id);

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.satuan.getEditForm', compact('data'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Satuan::find($id);

        $data->nama = $request->nama;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Data Satuan berhasil diperbarui!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Satuan::find($id);

        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Satuan <b>' . $data->nama . '</b> berhasil dihapus!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus! Satuan ini sedang dipakai oleh tabel lain (contoh: Bahan Baku).'
            ], 200);
        }
    }
}
