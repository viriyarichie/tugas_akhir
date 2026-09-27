<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.supplier.index', ['suppliers' => $suppliers]);
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
        $supplier = new Supplier();
        $supplier->nama_supplier = $request->input('nama_supplier');
        $supplier->kontak = $request->input('kontak');
        $supplier->alamat = $request->input('alamat');
        $supplier->save();

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier created successfully.');
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
        $data = Supplier::find($id);

        return response()->json([
            'status' => 'oke',
            'msg' => view('admin.supplier.getEditForm', compact('data'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Supplier::find($id);

        $data->nama_supplier = $request->nama_supplier;
        $data->kontak = $request->kontak;
        $data->alamat = $request->alamat;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Data Supplier berhasil diperbarui!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        // $this->authorize('delete-permission', Auth::user()); // Sesuai project lama jika ada gate khusus delete

        $id = $request->id;
        $data = Supplier::find($id);

        try {
            $data->delete();
            return response()->json([
                'status' => 'oke',
                'msg' => 'Supplier <b>' . $data->nama_supplier . '</b> berhasil dihapus!'
            ], 200);
        } catch (\PDOException $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Gagal menghapus Supplier!'
            ], 200);
        }
    }
}
