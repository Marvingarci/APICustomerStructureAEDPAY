<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function getInvoicesByLocation($locationID)
    {
        $invoicesPending = DB::table('invoices')->where([['locationID', $locationID],['statusin', 'pending']])->get();
        $invoicesPayed = DB::table('invoices')->where([['locationID', $locationID],['statusin', 'payed']])->get();
        return response()->json([
            'invoicesPending'=> $invoicesPending,
            'invoicesPayed'=> $invoicesPayed,
        ], 201);
    }
}
