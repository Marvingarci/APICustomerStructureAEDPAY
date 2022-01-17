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
        $account->primaryAccPmaId = $data['primaryAccPmaId']; 
        $account->fullName = $data['fullName'];
        $account->ccn = $data['ccn'];
        $account->exMonth = $data['exMonth'];
        $account->exYear = $data['exYear'];
        $account->ccv = $data['ccv'];
        $account->cardType = '';
        $account->address = $data['address'];
        $account->address2 = $data['address2'];
        $account->city = $data['city'];
        $account->state = $data['state'];
        $account->zip = $data['zip'];
        $account->phone = $data['phone'];
        $account->status = true;
        $account->save();

        foreach ($locationsToAttachPrimary as $location) {
            if($location != null){
                $location = LocationAcc::where('locationId', $location)->first();
                $location->paymentTypePayId = $uuid;
                $location->save();
            } 
        }

        foreach ($locationsToAttachBackUp as $location) {
            if($location != null){
                $location = LocationAcc::where('locationId', $location)->first();
                $location->paymentType2PayId = $account->payId;
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
        $payments = PaymentType::where([['primaryAccPmaId', $id],['status',1]])->with(["locations" => function($q){
            $q->where('location_accs.status', '=', 1);
        }, "locationsBackUp" => function($q){
            $q->where('location_accs.status', '=', 1);
        }])->get();
        $locations = LocationAcc::where([['primaryAccPmaId', $id], ['status', true]])->get();

        $locationsWP = LocationAcc::where([['primaryAccPmaId', $id], ['paymentTypePayId', null], ['status', true]])->get();
        $locationsNP = LocationAcc::where([['primaryAccPmaId', $id], ['paymentType2PayId', null], ['status', true]])->get();
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
        $account->primaryAccPmaId = $data['primaryAccPmaId']; 
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
        $account->phone = $data['phone'];
        $account->save();


        foreach ($locationsToAttachPrimary as $location) {
            if($location != null){
                $location = LocationAcc::where('locationId', $location)->first();
                $location->paymentTypePayId = $account->payId;
                $location->save();
            } 
        }

        foreach ($locationsToAttachBackUp as $location) {
            if($location != null){
                $location = LocationAcc::where('locationId', $location)->first();
                $location->paymentType2PayId = $account->payId;
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
        $location = LocationAcc::where('locationId', $payment['locationId'])->first();
        $location->paymentTypePayId = null;
        $location->save();

        return response()->json([
            'message' => 'Payment method deselected succesfully'
        ], 201);
    }

    public function destroyBackUp(LocationAcc $payment)
    {
        $location = LocationAcc::where('locationId', $payment['locationId'])->first();
        $location->paymentType2PayId = null;
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
            $location = LocationAcc::where('locationId', $location['locationId'])->first();
            $location->paymentTypePayId = null;
            $location->save();
        }

        foreach ($locationsBackUp as $location) {
            $location = LocationAcc::where('locationId', $location['locationId'])->first();
            $location->paymentType2PayId = null;
            $location->save();
        }

        return response()->json([
            'message' => 'Payment method disable succesfully'
        ], 201);
    }
}
