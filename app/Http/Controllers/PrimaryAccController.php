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
use Mail;

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
    public function verifyEmail($code)
    {
        $primaryAcc = PrimaryAcc::where('remember_token', $code)->first();
        if($primaryAcc == null){
            return response()->json([
                'message' => 'Wrong code'
            ], 201);
        }else{
            $primaryAcc->email_verified_at = date('d-m-y h:i:s');
            $primaryAcc->save();
            return response()->json([
                'message' => 'Account verified succesfully'
            ], 201);
        }

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
        $account->pmaId = $uuid; 
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
        $codeToVerify = rand(100000, 999999);
        $data = $request->validated();

        $corporate = DB::table('corporate_customers')->where('corpCode', $data['aedAsignType'])->first();

        $account = new User;
        $account->pmaId = $uuid; 
        $account->firstName = $data['firstName'];
        $account->lastName = $data['lastName'];
        $account->email = $data['email'];
        $account->aedAsignType = $corporate->corpId;
        $account->password = bcrypt($data['password']);
        $account->remember_token = $codeToVerify;
        $account->save();

      
        //send email
        $subject = "Verification Email aedpay customers";
        $email = $data['email'];
        $data = [
            'code' => $codeToVerify,
            'name'=> $data['firstName']
          ];
        Mail::send('emailPaymentVerifications', $data, function($msj) use($subject, $email ){
            $msj->from("noreply@aedpay.com","aedpay");
            $msj->subject($subject);
            $msj->to($email);            
        }); 
        

        return response()->json([
            'message' => 'Account created succesfully'
        ], 201);
    }

    public function sendEmailToChangePassword($email)
    {
        $primary = PrimaryAcc::where('email', $email)->first();

        if(is_null($primary)){
            return response()->json([
                'message' => 'No account'
            ], 200);
        }
      
        //send email
        $subject = "Password Change aedpay";
        $data = [
            'code' => $primary->pmaId,
            'name'=> $primary->firstName.' '.$primary->lastName
          ];
        Mail::send('changePassword', $data, function($msj) use($subject, $email ){
            $msj->from("noreply@aedpay.com","aedpay");
            $msj->subject($subject);
            $msj->to($email);            
        }); 
        

        return response()->json([
            'message' => 'Email sent successfuly'
        ], 201);
    }

    public function changePassword(Request $request)
    {
        
        $primary = PrimaryAcc::where('pmaId', $request['pmaId'])->first();
        $primary->password = bcrypt($request['password']);
        $primary->save();

        return response()->json([
            'message' => 'Password change succesfuly'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrimaryAcc  $primaryAcc
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {

       // $primaryAcc = PrimaryAcc::find($id)->with(['locations']);
        $primaryAcc = DB::table('primary_accs')->where('pmaId', $uuid)->first();
        $corporate = DB::table('corporate_customers')->where('corpId', $primaryAcc->aedAsignType)->first();
        $locations = LocationAcc::where([['primaryAccPmaId', $primaryAcc->pmaId],['status', true]])->with(['contract', 'payment'])->get();
        $payments = PaymentType::where('primaryAccPmaId', $primaryAcc->pmaId)->with('locations')->get();
        return response()->json([
            'account'=> $primaryAcc,
            'locations' => $locations,
            'payments' => $payments,
            'corporate'=> $corporate
        ]);
    }

    public function showLoggedUser($uuid)
    {
        $primaryAcc = DB::table('primary_accs')->where('pmaId', $uuid)->first();
        $corporate = DB::table('corporate_customers')->where('corpId', $primaryAcc->aedAsignType)->first();
        return response()->json([
            'account'=> $primaryAcc,
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
