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
    public function transaksi_satu(Request $request)
    {
        $validatedData = $request->validate([
            'sales_id' => 'required',
            'tgl' => 'required',
            'barang_id' => 'required',
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'harga_bandrol' => 'required',
            'qty' => 'required',
            'diskon_pct' => 'sometimes',
            'diskon_nilai' => 'sometimes',
            'harga_diskon' => 'sometimes',
            'total' => 'required'
        ]);

        $detail = SalesDetailModel::create($validatedData);

        return response()->json($detail, 201);
    }

    public function transaksi(Request $request, $id)
    {
        try {

            $transaksi = SalesModel::find($id);


            $transaksi->qty = $request->input('qty', $transaksi->qty);
            $transaksi->ongkir = $request->input('ongkir', $transaksi->ongkir);
            $transaksi->nama_barang = $request->input('nama_barang', $transaksi->nama_barang);
            $transaksi->save();


            if ($request->has('qty')) {
                $detail = SalesDetailModel::where('sales_id', $transaksi->id)->first();
                $detail->qty = $request->input('qty');
                $detail->save();
            }


            if ($request->has('ongkir')) {
                $detail = SalesDetailModel::where('sales_id', $transaksi->id)->first();
                $detail->ongkir = $request->input('ongkir');
                $detail->save();
            }

            return response()->json(['msg' => 'Pengajar updated successfully', 'updatedPengajar' => $transaksi], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // public function createTransaksi(Request $request)
    // {
    //     try {
    //         // Membuat instance baru dari SalesModel dan menyimpannya
    //         $transaksi = new SalesModel;
    //         $transaksi->qty = $request->input('qty');
    //         $transaksi->ongkir = $request->input('ongkir');
    //         $transaksi->nama_barang = $request->input('nama_barang');
    //         $transaksi->save();

    //         // Membuat instance baru dari SalesDetailModel dan menyimpannya
    //         $detail = new SalesDetailModel;
    //         $detail->sales_id = $transaksi->id;
    //         $detail->qty = $request->input('qty');
    //         $detail->ongkir = $request->input('ongkir');
    //         $detail->nama_barang = $request->input('nama_barang');
    //         $detail->save();

    //         return response()->json(['msg' => 'Transaksi created successfully', 'transaksi' => $transaksi, 'detail' => $detail], 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }

    // public function createTransaksi(Request $request)
    // {

    //     $validated = $request->validate([

    //         'diskon' => 'required|numeric',
    //         'diskon_nilai' => 'required|numeric',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $transaksi = new SalesModel;
    //         $transaksi->diskon = $request->input('diskon');

    //         $transaksi->save();

    //         $detail = new SalesDetailModel;
    //         $detail->sales_id = $transaksi->id;
    //         $detail->diskon_nilai = $request->input('diskon_nilai');

    //         $detail->save();


    //         DB::commit();

    //         return response()->json(['msg' => 'Transaksi created successfully', 'transaksi' => $transaksi, 'detail' => $detail], 201);
    //     } catch (\Exception $e) {

    //         DB::rollBack();


    //         Log::error('Error creating transaksi: ' . $e->getMessage());


    //         return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
    //     }
    // }

    // public function createTransaksi(Request $request)
    // {
    //     $validated = $request->validate([
    //         'kode' => 'required|varchar',
    //         'tgl' => 'required|numeric',
    //         'cust_id' => 'required|integer',
    //         'subtotal' => 'required|numeric',
    //         'ongkir' => 'required|numeric',
    //         'total_bayar' => 'required|numeric',
    //         'harga_bandrol' => 'required|integer',
    //         'qty' => 'required|integer',
    //         'diskon_pct' => 'required|numeric',
    //         'harga_diskon' => 'required|numeric',
    //         'total' => 'required|numeric',
    //         'diskon' => 'required|numeric',
    //         'diskon_nilai' => 'required|numeric',
    //     ]);

    //     DB::beginTransaction();
    //     try {

    //         $transaksi = new SalesModel;
    //         $transaksi->diskon = $request->input('diskon');
    //         $transaksi->save();


    //         Log::info('ID Transaksi baru: ' . $transaksi->id);


    //         $detail = new SalesDetailModel;
    //         $detail->sales_id = $transaksi->id;
    //         $detail->harga_diskon = $request->input('harga_diskon');


    //         Log::info('SalesDetail akan disimpan dengan sales_id: ' . $detail->sales_id . ' dan diskon_nilai: ' . $detail->diskon_nilai);

    //         $detail->save();


    //         Log::info('SalesDetail berhasil disimpan: ', $detail->toArray());

    //         DB::commit();

    //         return response()->json(['msg' => 'Transaksi created successfully', 'transaksi' => $transaksi, 'detail' => $detail], 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         Log::error('Error creating transaksi: ' . $e->getMessage());

    //         return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
    //     }
    // }

    // public function createTransaksi(Request $request)
    // {
    //     $validated = $request->validate([
    //         'kode' => 'required|string',
    //         'tgl' => 'required|date',
    //         'cust_id' => 'required|integer',
    //         'subtotal' => 'required|numeric',
    //         'ongkir' => 'required|numeric',
    //         'total_bayar' => 'required|numeric',
    //         'barang_id' => 'required|numeric',
    //         'harga_bandrol' => 'required|integer',
    //         'qty' => 'required|integer',
    //         'diskon_pct' => 'required|numeric',
    //         'harga_diskon' => 'required|numeric',
    //         'total' => 'required|numeric',
    //         'diskon' => 'required|numeric',
    //         'diskon_nilai' => 'required|numeric',
    //     ]);

    //     $detail = null;

    //     DB::beginTransaction();
    //     try {
    //         $transaksi = new SalesModel;
    //         $transaksi->diskon = $request->input('diskon');
    //         $transaksi->kode = $request->input('kode');
    //         $transaksi->tgl = $request->input('tgl');
    //         $transaksi->cust_id = $request->input('cust_id');
    //         $transaksi->subtotal = $request->input('subtotal');
    //         $transaksi->ongkir = $request->input('ongkir');
    //         $transaksi->total_bayar = $request->input('total_bayar');
    //         $transaksi->save();

    //         if ($transaksi->save()) {
    //             Log::info('Sales transaction saved successfully with ID: ' . $transaksi->id);

    //             $detail = new SalesDetailModel;
    //             $detail->sales_id = $transaksi->id; 
    //             $detail->diskon_nilai = $request->input('diskon_nilai');
    //             $detail->barang_id = $request->input('barang_id');
    //             $detail->harga_bandrol = $request->input('harga_bandrol');
    //             $detail->qty = $request->input('qty');
    //             $detail->diskon_pct = $request->input('diskon_pct');
    //             $detail->harga_diskon = $request->input('harga_diskon');
    //             $detail->total = $request->input('total');
    //             $detail->save();

    //             Log::info('Sales detail saved successfully with sales_id: ' . $detail->sales_id);
    //         } else {
    //             throw new \Exception("Failed to save sales transaction");
    //         }

    //         DB::commit();

    //         return response()->json(['msg' => 'Transaksi created successfully', 'transaksi' => $transaksi, 'detail' => $detail], 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         Log::error('Error creating transaksi: ' . $e->getMessage());

    //         return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
    //     }
    // }

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
            // Temukan transaksi berdasarkan ID
            $transaksi = SalesModel::findOrFail($id);

            // Hapus semua detail terkait transaksi tersebut
            SalesDetailModel::where('sales_id', $transaksi->id)->delete();

            // Hapus transaksi itu sendiri
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
