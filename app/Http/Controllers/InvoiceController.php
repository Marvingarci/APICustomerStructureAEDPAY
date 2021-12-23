<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function getInvoicesByLocation($locationId)
    {
        $invoicesPending = DB::table('invoices')->where([['locationId', $locationId],['statusin', 'pending']])->get();
        $invoicesPayed = DB::table('invoices')->where([['locationId', $locationId],['statusin', 'paid']])->limit(2)->get();
        
        $receipts = DB::table('receipts')
                    ->join('receipt_items', 'receipts.idreceipt','=','receipt_items.idreceipt')
                    ->select('receipt_items.invoiceId', 'receipts.status', 'receipts.authCod', 'receipts.amount',  'receipts.date')
                    ->where('idlocation', $locationId)
                    ->get();

        return response()->json([
            'invoicesPending'=> $invoicesPending,
            'invoicesPayed'=> $invoicesPayed,
            'receipts'=> $receipts,
        ], 201);
    }
}
