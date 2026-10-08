<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Menu;
use App\Models\NotaJual;
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
        return view('kasir.nota-jual.index', ['notaJuals' => $notaJuals]);
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

        return redirect()->route('kasir.nota-jual.show', $nota->id_nota_jual);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notaJual = NotaJual::findOrFail($id);

        $detailPenjualans = DetailPenjualan::with('menu')->where('id_nota_jual', $id)->get();
        $menus = Menu::all();

        return view('kasir.nota-jual.show', [
            'notaJual' => $notaJual,
            'detailPenjualans' => $detailPenjualans,
            'menus' => $menus
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
}
