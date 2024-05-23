<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\CustomerModel;

class CustomerController extends Controller
{
    public function indexCustomer()
    {
        $customer = CustomerModel::get();
        return response()->json(['msg' => 'Data retrieved', 'data' => $customer], 200);
    }

    public function storeCustomer(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'required',
            'name' => 'required',
            'telp' => 'required'
        ]);

        $customer = CustomerModel::create($validatedData);
        
        return response()->json($customer, 201);
    }

    public function showCustomer(CustomerModel $customer)
    {
        return response()->json($customer);
    }

    public function updateCustomer(Request $request, CustomerModel $customer)
    {
        $validatedData = $request->validate([
            'kode' => 'required',
            'name' => 'required',
            'telp' => 'required'
        ]);

        $customer->update($validatedData);

        return response()->json($customer, 200);
    }

    public function destroyCustomer(CustomerModel $customer){
        $customer->delete();
        return response()->json(null,204);
    }
}
