<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContractRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StoreContractRequest $request)
    {
        $uuid = Str::uuid()->toString();

        $data = $request->validated();

        $contract = new Contract;
        $contract->contractId = $uuid; 
        $contract->locationAccLocationId = $data['locationAccLocationId'];
        $contract->servicesCatalogCorpId = $data['servicesCatalogCorpId'];
        $contract->fullName = $data['fullName'];
        $contract->terms = $data['terms'];
        $contract->description = $data['description'];
        $contract->amount = $data['amount'];
        $contract->numMonth = $data['numMonth'];
        $contract->numPayments = $data['numPayments'];
        $contract->contractBody = $data['contractBody'];
        $contract->startDate = $data['startDate'];
        $contract->endDate = $data['endDate'];
        $contract->status = $data['status'];
        $contract->signature = $data['signature'];
        $contract->save();

        return response()->json([
            'message' => 'Contract created succesfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $contracts = DB::table('services_catalogs')->where('corcusID', $id)->get();
        //  $locations = LocationAcc::where('primaryAccPmaId', $primaryAcc->pmaID)->get();
        //  $payments = PaymentType::where('primaryAccPmaId', $primaryAcc->pmaID)->with('locations')->get();
         return response()->json([
             'contracts'=> $contracts
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
