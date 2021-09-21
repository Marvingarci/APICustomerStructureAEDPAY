<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\LocationAcc;


class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(PaymentType::all()->with('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        $uuid = Str::uuid()->toString();

        $data = $request->validated();
        $locations = $data['locationsToAttach'];

        $account = new PaymentType;
        $account->payId = $uuid; 
        $account->primary_acc_pmaID = $data['primary_acc_pmaID']; 
        $account->fullName = $data['fullName'];
        $account->ccn = $data['ccn'];
        $account->exMonth = $data['exMonth'];
        $account->exYear = $data['exYear'];
        $account->ccv = $data['ccv'];
        $account->cardType = $data['cardType'];
        $account->save();

        foreach ($locations as $location) {
            if($location != null){
                $location = LocationAcc::where('locationID', $location)->first();
                $location->payment_type_payId = $uuid;
                $location->save();
            } 
        }
        
        return response()->json([
            'message' => 'Payment method created succesfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payments = PaymentType::where('primary_acc_pmaID', $id)->with('locations')->get();
        $locations = LocationAcc::where('primary_acc_pmaID', $id)->get();
        return response()->json([
            'payments'=> $payments,
            'locations' => $locations
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentType $paymentType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymentType)
    {
        //
    }
}
