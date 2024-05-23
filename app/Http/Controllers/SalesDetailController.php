<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesDetailRequest;
use App\Models\SalesDetailModel;
use App\Models\SalesModel;


class SalesDetailController extends Controller
{
    public function indexSalesDetail()
    {
        $detail = SalesDetailModel::join('t_sales', 't_sales_det.sales_id', '=', 't_sales.id')
            ->join('m_customer', 't_sales.cust_id', '=', 'm_customer.id') // join dengan tabel m_customer
            ->join('m_barang', 't_sales_det.barang_id', '=', 'm_barang.id')
            ->select('t_sales_det.*', 'm_customer.name as nama_customer', 'm_customer.kode as kode_customer', 'm_customer.telp as telp', 't_sales_det.qty as qty', 'm_barang.kode as kode_barang', 'm_barang.nama as nama_barang', 'm_barang.harga as harga', 't_sales.ongkir as ongkir') // pilih kolom yang diinginkan dari m_customer
            ->get();


        return response()->json(['msg' => 'Data retrieved', 'data' => $detail], 200);
    }

    public function storeSalesDetail(Request $request)
    {
        $validatedData = $request->validate([
            'sales_id' => 'required',
            'barang_id' => 'required',
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


    public function updateSalesDetail(Request $request, SalesDetailModel $detail)
    {
        $validatedData = $request->validate([
            'sales_id' => 'required',
            'barang_id' => 'required',
            'harga_bandrol' => 'required',
            'qty' => 'required',
            'diskon_pct' => 'sometimes',
            'diskon_nilai' => 'sometimes',
            'harga_diskon' => 'sometimes',
            'total' => 'required'
        ]);

        $detail->update($validatedData);

        return response()->json($detail, 200);
    }

    public function destroySalesDetail(SalesDetailModel $detail)
    {
        $detail->delete();
        return response()->json(null, 204);
    }
}
