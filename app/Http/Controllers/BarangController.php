<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarangRequest;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function indexBarang()
    {
        $barang = BarangModel::get();
        return response()->json(['msg' => 'Data retrieved', 'data' => $barang], 200);
    }

    public function storeBarang(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'harga' => 'required'
        ]);

        $barang = BarangModel::create($validatedData);
        
        return response()->json($barang, 201);
    }

    public function showBarang(BarangModel $barang)
    {
        return response()->json($barang);
    }

    public function updateBarang(Request $request, BarangModel $barang)
    {
        $validatedData = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'harga' => 'required'
        ]);

        $barang->update($validatedData);

        return response()->json($barang, 200);
    }

    public function destroyBarang(BarangModel $barang){
        $barang->delete();
        return response()->json(null,204);
    }

}
