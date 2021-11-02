<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function getInvoicesByLocation($locationID)
    {
        $invoicesPending = DB::table('invoices')->where([['locationID', $locationID],['statusin', 'pending']])->get();
        $invoicesPayed = DB::table('invoices')->where([['locationID', $locationID],['statusin', 'paid']])->limit(2)->get();
        
        $receipts = DB::table('receipts')
                    ->join('receipt_items', 'receipts.idreceipt','=','receipt_items.idreceipt')
                    ->select('receipt_items.invoiceID', 'receipts.status', 'receipts.authCod', 'receipts.amount',  'receipts.date')
                    ->where('idlocation', $locationID)
                    ->get();

        return response()->json([
            'invoicesPending'=> $invoicesPending,
            'invoicesPayed'=> $invoicesPayed,
            'receipts'=> $receipts,
        ], 201);
    }
}
