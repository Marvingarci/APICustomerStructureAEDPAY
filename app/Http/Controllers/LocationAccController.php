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
        $account->locationID = $uuid; 
        $account->primary_acc_pmaID = $data['primary_acc_pmaID']; 
        $account->username = $data['username'];
        $account->password = bcrypt($data['password']);
        $account->locationName = $data['locationName'];
        $account->companyLegalName = $data['companyLegalName'];
        $account->dbDestination = $data['dbDestination'];
        $account->locationDestination = $data['locationDestination'];
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

        $data = [
            'location' => 'Dareville',
            'companyLegalName' => 'Liliana-s Cars',
            'dbDestination' => 'aedPayLiliana',
            'locationDestination' => 'cfsMiami'
        ];

        $data2 = [
            'location' => 'RiverDale',
            'companyLegalName' => 'Champions Bros',
            'dbDestination' => 'aedPayMelvin',
            'locationDestination' => 'cfsMelbourne'
        ];

        $data3 = [
            'location' => 'MiamiCfs',
            'companyLegalName' => 'Ipsa',
            'dbDestination' => 'aedPayIpsa',
            'locationDestination' => 'cfsColombia'
        ];

        if($request->username == 'marvingarci' && $request->password == 'Malegar2015!'){
            return response()->json([
                'message'=> 'Success',
                'data' => $data
            ], 201);
        } else if ($request->username == 'melvinsevi' && $request->password == 'Malegar2015!'){
            return response()->json([
                'message'=> 'Success',
                'data' => $data2
            ], 201);
        }else if ($request->username == 'lilianagarci' && $request->password == 'Malegar2015!'){
            return response()->json([
                'message'=> 'Success',
                'data' => $data3
            ], 201);
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
        $p = LocationAcc::where('locationID', $request->locationID)->first();
        // $locationsPrimary = $p->locations;
        // $locationsBackUp = $p->locationsBackUp;
        //dd($p);
        $p->status = false;
        $p->save();

        // foreach ($locationsPrimary as $location) {
        //     $location = LocationAcc::where('locationID', $location['locationID'])->first();
        //     $location->payment_type_payId = null;
        //     $location->save();
        // }

        // foreach ($locationsBackUp as $location) {
        //     $location = LocationAcc::where('locationID', $location['locationID'])->first();
        //     $location->payment_type2_payId = null;
        //     $location->save();
        // }

        return response()->json([
            'message' => 'Location disable succesfully'
        ], 201);
    }
}
