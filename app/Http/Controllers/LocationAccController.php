<?php

namespace App\Http\Controllers;

use App\Models\LocationAcc;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class LocationAccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(LocationAcc::all()->with(['contract']));

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
    public function store(StoreLocation $request)
    {
        $uuid = Str::uuid()->toString();

        $data = $request->validated();

        $account = new LocationAcc;
        $account->locationId = $uuid; 
        $account->DID = $data['DID']; 
        $account->primaryAccPmaId = $data['primaryAccPmaId']; 
        $account->fullName = $data['fullName']; 
        $account->username = $data['username'];
        $account->password = $data['password'];
        $account->locationName = $data['locationName'];
        $account->companyLegalName = $data['companyLegalName'];
        $account->dbServer = $data['dbServer'];
        $account->locationShort = $data['locationShort'];
        $account->status = true;
        $account->save();

        return response()->json([
            'message' => 'Location created succesfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $LocationAcc = LocationAcc::find($id);
        return response()->json([
            'location'=> $LocationAcc
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return \Illuminate\Http\Response
     */
    public function edit(LocationAcc $locationAcc)
    {
        if($locationAcc->status == 0){
            $locationAcc->update(['status' => 1]);
        }else{
            $locationAcc->update(['status' => 0]);
        }

        return response()->json([
            'Cambiado con exito'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocationAcc $locationAcc)
    {
        
        $datavalidated = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = DB::table('Settings')
        ->where('xx_user_name_tx','=', $request->username)
        ->where('xx_password_tx','=',$request->password)-> //here I comment this
        first();

        //dd($user);
        // $data = [
        //     'location' => 'Dareville',
        //     'companyLegalName' => 'Liliana-s Cars',
        //     'dbServer' => 'aedPayLiliana',
        //     'locationDestination' => 'cfsMiami'
        // ];

        // $data2 = [
        //     'location' => 'RiverDale',
        //     'companyLegalName' => 'Champions Bros',
        //     'dbServer' => 'aedPayMelvin',
        //     'locationDestination' => 'cfsMelbourne'
        // ];

        // $data3 = [
        //     'location' => 'MiamiCfs',
        //     'companyLegalName' => 'Ipsa',
        //     'dbServer' => 'aedPayIpsa',
        //     'locationDestination' => 'cfsColombia'
        // ];
        
        if(!is_null($user)){


            return response()->json([
                'message'=> 'Success',
                'data' => $user
            ], 200);
        }else{
            return response()->json([
                'message'=> 'Invalid credentials'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationAcc $locationAcc)
    {
        
    }


    public function disableLocation(Request $request)
    {
        $p = LocationAcc::where('locationId', $request->locationId)->first();
        // $locationsPrimary = $p->locations;
        // $locationsBackUp = $p->locationsBackUp;
        //dd($p);
        $p->status = false;
        $p->save();

        // foreach ($locationsPrimary as $location) {
        //     $location = LocationAcc::where('locationId', $location['locationId'])->first();
        //     $location->paymentTypePayId = null;
        //     $location->save();
        // }

        // foreach ($locationsBackUp as $location) {
        //     $location = LocationAcc::where('locationId', $location['locationId'])->first();
        //     $location->paymentType2PayId = null;
        //     $location->save();
        // }

        return response()->json([
            'message' => 'Location disable succesfully'
        ], 201);
    }
}
