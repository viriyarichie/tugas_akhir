<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        $kategoriMenus = KategoriMenu::all();
        return view('admin.menu.index', ['menus' => $menus, 'kategoriMenus' => $kategoriMenus]);
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
        $menu = new Menu();
        $menu->nama = $request->input('nama');
        $menu->harga_jual = $request->input('harga_jual');
        $menu->kategori_menu_id = $request->input('kategori_menu_id');
        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu created successfully.');
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
        $data = Menu::find($id);
        $kategoriMenus = KategoriMenu::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.menu.getEditForm', compact('data', 'kategoriMenus'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Menu::find($id);

        $data->nama = $request->nama;
        $data->harga_jual = $request->harga_jual;
        $data->kategori_menu_id = $request->kategori_menu_id;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Data Menu berhasil diperbarui!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        // $this->authorize('delete-permission', Auth::user()); // Sesuai project lama jika ada gate khusus delete

        $id = $request->id;
        $data = Menu::find($id);

        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Menu <b>' . $data->nama . '</b> berhasil dihapus!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus! Pastikan kategori ini tidak sedang dipakai di tabel Menu.'
            ], 200);
        }
    }
}
