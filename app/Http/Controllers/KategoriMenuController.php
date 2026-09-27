<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriMenu;
use Illuminate\Support\Facades\Auth;

class KategoriMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriMenus = KategoriMenu::all();
        return view('admin.kategori-menu.index', ['kategoriMenus' => $kategoriMenus]);
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
        $kategori = new KategoriMenu();
        $kategori->nama_kategori = $request->get('nama');
        $kategori->save();

        return redirect()->route('admin.kategori-menu.index')->with('success', 'Kategori Menu created successfully.');
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
        $data = KategoriMenu::find($id);

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.kategori-menu.getEditForm', compact('data'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = KategoriMenu::find($id);

        $data->nama_kategori = $request->nama;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Data Kategori Menu berhasil diperbarui!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        // $this->authorize('delete-permission', Auth::user()); // Sesuai project lama jika ada gate khusus delete

        $id = $request->id;
        $data = KategoriMenu::find($id);

        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Kategori <b>' . $data->nama_kategori . '</b> berhasil dihapus!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus! Pastikan kategori ini tidak sedang dipakai di tabel Menu.'
            ], 200);
        }
    }
}
