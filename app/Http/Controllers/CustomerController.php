<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SaleImport;
use App\Models\Customer;
class CustomerController extends Controller
{
    public function searchCustomer(Request $request) {
        $cuit = $request->input('cuit');

        if (Customer::find($cuit)) {
            $cliente= Customer::where('CUITCliente', $cuit)->first();
            return view('modifyCustomer', ['Cliente' => $cliente]);
        } else {
            $msg = "Invalid credentials or customer not found|exists";
            return redirect('/?msg=' . urlencode($msg));
        }
    }

    public function modifyCustomer(Request $request, $CUITCliente) {
        //$cliente = Cliente::where('CUITCliente', $CUITCliente)->first();
        $customer = Customer::find($CUITCliente);
        if ($customer) {
            DB::beginTransaction();
            $d = ['CUITCliente' => $request->input('cuit'),
                'RazonSocial' => $request->input('razonsocial'),
                'NroCliente' => $request->input('nro'),];
            $customer->update($d);
            DB::commit();
            $msg = "Customer updated successfully";
        } else {
            $msg = "Customer not found|exists or invalid credentials";
        }
        return redirect('/?msg=' . urlencode($msg));
    }

    public function addCustomer(Request $request) {
        /**
         * Here we get the data from the form and create a new customer
         */
        $msg = "";
        $cuit = $request->input('cuit');
        $nro = $request->input('nro');
        
        $razonsocial = $request->input('razonsocial');
        $cliente = Customer::where('CUITCliente', $cuit)
                ->orWhere('NroCliente', $nro)
                ->orWhere('RazonSocial', $razonsocial)
                ->first();
        if ($cliente) {
            $msg = 'CUITCliente or Nro. Razon Social already exists !';
        } else {
            DB::beginTransaction();
            $CustomerData = [
                'CUITCliente' => $cuit,
                'RazonSocial' => $razonsocial,
                'NroCliente' => $nro,
            ];
            Customer::create($CustomerData);
            DB::commit();
            $msg = 'Customer created successfully';
        }
        return redirect("/addCustomer?msg=" . urlencode($msg));
    }
    public function Back() {
        return redirect("/");
    }
}
