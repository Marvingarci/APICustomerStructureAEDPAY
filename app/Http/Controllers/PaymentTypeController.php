<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePaymentRequest;
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
        $locationsToAttachPrimary = $data['locationsToAttachPrimary'];
        $locationsToAttachBackUp = $data['locationsToAttachBackUp'];

        $account = new PaymentType;
        $account->payId = $uuid; 
        $account->primary_acc_pmaID = $data['primary_acc_pmaID']; 
        $account->fullName = $data['fullName'];
        $account->ccn = $data['ccn'];
        $account->exMonth = $data['exMonth'];
        $account->exYear = $data['exYear'];
        $account->ccv = $data['ccv'];
        $account->cardType = $data['cardType'];
        $account->address = $data['address'];
        $account->address2 = $data['address2'];
        $account->city = $data['city'];
        $account->state = $data['state'];
        $account->zip = $data['zip'];
        $account->status = true;
        $account->save();

        foreach ($locationsToAttachPrimary as $location) {
            if($location != null){
                $location = LocationAcc::where('locationID', $location)->first();
                $location->payment_type_payId = $uuid;
                $location->save();
            } 
        }

        foreach ($locationsToAttachBackUp as $location) {
            if($location != null){
                $location = LocationAcc::where('locationID', $location)->first();
                $location->payment_type2_payId = $account->payId;
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
        $payments = PaymentType::where([['primary_acc_pmaID', $id],['status',1]])->with(['locations', 'locationsBackUp'])->get();
        $locations = LocationAcc::where('primary_acc_pmaID', $id)->get();

        $locationsWP = LocationAcc::where([['primary_acc_pmaID', $id], ['payment_type_payId', null]])->get();
        $locationsNP = LocationAcc::where([['primary_acc_pmaID', $id], ['payment_type2_payId', null]])->get();
        return response()->json([
            'payments'=> $payments,
            'locations' => $locations,
            'locationsWithPrimary' => $locationsWP,
            'locationsNoPrimary' => $locationsNP,  

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
    public function update(UpdatePaymentRequest $request)
    {
        $data = $request->validated();
        $locationsToAttachPrimary = $data['locationsToAttachPrimary'];
        $locationsToAttachBackUp = $data['locationsToAttachBackUp'];

        $account = PaymentType::where('payId', $data['payId'])->first();
        $account->primary_acc_pmaID = $data['primary_acc_pmaID']; 
        $account->fullName = $data['fullName'];
        $account->ccn = $data['ccn'];
        $account->address = $data['address'];
        $account->address2 = $data['address2'];
        $account->city = $data['city'];
        $account->state = $data['state'];
        $account->zip = $data['zip'];
        $account->exMonth = $data['exMonth'];
        $account->exYear = $data['exYear'];
        $account->ccv = $data['ccv'];
        $account->cardType = $data['cardType'];
        $account->save();


        foreach ($locationsToAttachPrimary as $location) {
            if($location != null){
                $location = LocationAcc::where('locationID', $location)->first();
                $location->payment_type_payId = $account->payId;
                $location->save();
            } 
        }

        foreach ($locationsToAttachBackUp as $location) {
            if($location != null){
                $location = LocationAcc::where('locationID', $location)->first();
                $location->payment_type2_payId = $account->payId;
                $location->save();
            } 
        }
        
        return response()->json([
            'message' => 'Payment method edited succesfully'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationAcc $payment)
    {
        $location = LocationAcc::where('locationID', $payment['locationID'])->first();
        $location->payment_type_payId = null;
        $location->save();

        return response()->json([
            'message' => 'Payment method deselected succesfully'
        ], 201);
    }

    public function destroyBackUp(LocationAcc $payment)
    {
        $location = LocationAcc::where('locationID', $payment['locationID'])->first();
        $location->payment_type2_payId = null;
        $location->save();

        return response()->json([
            'message' => 'Payment method deselected succesfully'
        ], 201);
    }

    public function disablePayment(Request $payment)
    {
        $p = PaymentType::where('payId', $payment->payId)->with(['locations','locationsBackUp'])->first();
        // dd($p->locationsBackUp);
        $locationsPrimary = $p->locations;
        $locationsBackUp = $p->locationsBackUp;
        $p->status = false;
        $p->save();

        foreach ($locationsPrimary as $location) {
            $location = LocationAcc::where('locationID', $location['locationID'])->first();
            $location->payment_type_payId = null;
            $location->save();
        }

        foreach ($locationsBackUp as $location) {
            $location = LocationAcc::where('locationID', $location['locationID'])->first();
            $location->payment_type2_payId = null;
            $location->save();
        }

        return response()->json([
            'message' => 'Payment method disable succesfully'
        ], 201);
    }
}
