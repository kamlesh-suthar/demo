<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::select('id', 'first_name', 'last_name', 'email');
            if ($request->search['value']) {
//                $customers = $customers->orWhere('first_name', 'like', '%' . $request->search['value'] . '%');
                return datatables($customers)->toJson();
            } else {
                return datatables($customers)->toJson();
            }
        }
        return view('customer.index');
    }

    public function edit(Request $request, Customer $customer)
    {
        dd($customer);
    }

    public function destroy(Request $request, Customer $customer)
    {
        dd($customer);
    }
}
