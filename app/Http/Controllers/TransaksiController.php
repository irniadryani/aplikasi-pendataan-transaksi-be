<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesDetailRequest;
use App\Models\SalesDetailModel;
use App\Models\SalesModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function createTransaksi(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string',
            'tgl' => 'required|date',
            'cust_id' => 'required|integer',
            'subtotal' => 'required|numeric',
            'ongkir' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'diskon' => 'required|numeric',
            'barang' => 'required|array',
            'barang.*.barang_id' => 'required|integer',
            'barang.*.harga_bandrol' => 'required|integer',
            'barang.*.qty' => 'required|integer',
            'barang.*.diskon_pct' => 'required|numeric',
            'barang.*.diskon_nilai' => 'required|numeric',
            'barang.*.harga_diskon' => 'required|numeric',
            'barang.*.total' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = new SalesModel;
            $transaksi->kode = $request->input('kode');
            $transaksi->tgl = $request->input('tgl');
            $transaksi->cust_id = $request->input('cust_id');
            $transaksi->subtotal = $request->input('subtotal');
            $transaksi->diskon = $request->input('diskon');
            $transaksi->ongkir = $request->input('ongkir');
            $transaksi->total_bayar = $request->input('total_bayar');
            $transaksi->save();

            $barangArray = $request->input('barang');

            foreach ($barangArray as $barang) {
                $detail = new SalesDetailModel;
                $detail->sales_id = $transaksi->id;
                $detail->barang_id = $barang['barang_id'];
                $detail->harga_bandrol = $barang['harga_bandrol'];
                $detail->qty = $barang['qty'];
                $detail->diskon_pct = $barang['diskon_pct'];
                $detail->diskon_nilai = $barang['diskon_nilai'];
                $detail->harga_diskon = $barang['harga_diskon'];
                $detail->total = $barang['total'];
                $detail->save();
            }

            DB::commit();

            return response()->json(['msg' => 'Transaksi created successfully', 'transaksi' => $transaksi, 'details' => $barangArray], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error creating transaksi: ' . $e->getMessage());

            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteTransaksi($id)
    {
        DB::beginTransaction();
        try {
            $transaksi = SalesModel::findOrFail($id);

            SalesDetailModel::where('sales_id', $transaksi->id)->delete();

            $transaksi->delete();

            DB::commit();

            return response()->json(['msg' => 'Transaksi deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting transaksi: ' . $e->getMessage());

            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }
}
