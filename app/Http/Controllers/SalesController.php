<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesRequest;
use App\Models\SalesModel;

class SalesController extends Controller
{
    public function indexSales()
    {
        $sales = SalesModel::join('m_customer', 't_sales.cust_id', '=', 'm_customer.id')
            ->join('t_sales_det', 't_sales.id', '=', 't_sales_det.sales_id')
            ->select('t_sales.*', 'm_customer.name as nama', 't_sales_det.qty as qty')
            ->get();

        return response()->json(['msg' => 'Data retrieved', 'data' => $sales], 200);
    }

    public function storeSales(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'required',
            'tgl' => 'required',
            'cust_id' => 'required',
            'subtotal' => 'required',
            'diskon' => 'sometimes',
            'ongkir' => 'required',
            'total_bayar' => 'required'
        ]);

        $sales = SalesModel::create($validatedData);

        return response()->json($sales, 201);
    }

    public function updateSales(Request $request, SalesModel $sales)
    {
        $validatedData = $request->validate([
            'kode' => 'required',
            'tgl' => 'required',
            'cust_id' => 'required',
            'subtotal' => 'required',
            'diskon' => 'sometimes',
            'ongkir' => 'required',
            'total_bayar' => 'required'
        ]);

        $sales->update($validatedData);

        return response()->json($sales, 200);
    }

    public function destroySales(SalesModel $sales)
    {
        $sales->delete();
        return response()->json(null, 204);
    }
}
