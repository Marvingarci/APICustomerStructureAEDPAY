<?php

namespace App\Http\Controllers;

use App\Models\PrimaryAcc;
use App\Models\LocationAcc;
use App\Models\User;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Requests\StorePrimaryAccount;
use App\Notifications\UpdatePasswordNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrimaryAccController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(PrimaryAcc::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrimaryAccount $request)
    {
        $uuid = Str::uuid()->toString();

        $data = $request->validated();

        $account = new User;
        $account->pmaID = $uuid; 
        $account->firstName = $data['firstName'];
        $account->lastName = $data['lastName'];
        $account->email = $data['email'];
        $account->aedAsignType = $data['aedAsignType'];
        $account->password = bcrypt($data['password']);
        $account->save();

        //event(new Registered($account));

        // Auth::login($account);

        return response()->json([
            'message' => 'Account created succesfully'
        ], 201);
    }
    //this func is the same with store but store is under JWT auth and this one is open
    public function save(StorePrimaryAccount $request)
    {
        $uuid = Str::uuid()->toString();

        $data = $request->validated();

        $account = new User;
        $account->pmaID = $uuid; 
        $account->firstName = $data['firstName'];
        $account->lastName = $data['lastName'];
        $account->email = $data['email'];
        $account->aedAsignType = $data['aedAsignType'];
        $account->password = bcrypt($data['password']);
        $account->save();

        // $user = User::create([
        //     'pmaID' => $account->pmaID = $uuid,
        //     'firstName' => $data['firstName'],
        //     'email' =>  $data['email'],
        //     'password' => bcrypt($data['password']),
        //     'aedAsignType' => $data['aedAsignType'],
        // ]);

        //event(new Registered($user));

        // Auth::login($account);

        return response()->json([
            'message' => 'Account created succesfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrimaryAcc  $primaryAcc
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {

       // $primaryAcc = PrimaryAcc::find($id)->with(['locations']);
        $primaryAcc = DB::table('primary_accs')->where('pmaID', $email)->first();
        $corporate = DB::table('corporate_customers')->where('CorpID', $primaryAcc->aedAsignType)->first();
        $locations = LocationAcc::where('primary_acc_pmaID', $primaryAcc->pmaID)->with(['contract', 'payment'])->get();
        $payments = PaymentType::where('primary_acc_pmaID', $primaryAcc->pmaID)->with('locations')->get();
        return response()->json([
            'account'=> $primaryAcc,
            'locations' => $locations,
            'payments' => $payments,
            'corporate'=> $corporate
        ]);
    }

 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrimaryAcc  $primaryAcc
     * @return \Illuminate\Http\Response
     */
    public function edit(PrimaryAcc $primaryAcc)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrimaryAcc  $primaryAcc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrimaryAcc $primaryAcc)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrimaryAcc  $primaryAcc
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrimaryAcc $primaryAcc)
    {
        //
    }
}
