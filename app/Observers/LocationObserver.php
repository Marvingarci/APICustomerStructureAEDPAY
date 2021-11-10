<?php

namespace App\Observers;

use App\Models\LocationAcc;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class LocationObserver
{
    /**
     * Handle the LocationAcc "created" event.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return void
     */
    public function created(LocationAcc $locationAcc)
    {
        //
    }

    /**
     * Handle the LocationAcc "updated" event.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return void
     */
    public function updated(LocationAcc $locationAcc)
    {
        $uuid = Str::uuid()->toString();

        DB::table('locations_log')->insert([
            'locationID' => $locationAcc->locationID ,
            'primary_acc_pmaID' => $locationAcc->primary_acc_pmaID,
            'payment_type_payId' => $locationAcc->payment_type_payId,
            'payment_type2_payId' => $locationAcc->payment_type2_payId,
            'username' => $locationAcc->username,
            'password' => $locationAcc->password,
            'locationName' => $locationAcc->locationName,
            'companyLegalName' => $locationAcc->companyLegalName,
            'dbDestination' => $locationAcc->dbDestination,
            'locationDestination' => $locationAcc->locationDestination,
            'status' => $locationAcc->status,
        ]);
    }

    /**
     * Handle the LocationAcc "deleted" event.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return void
     */
    public function deleted(LocationAcc $locationAcc)
    {
        //
    }

    /**
     * Handle the LocationAcc "restored" event.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return void
     */
    public function restored(LocationAcc $locationAcc)
    {
        //
    }

    /**
     * Handle the LocationAcc "force deleted" event.
     *
     * @param  \App\Models\LocationAcc  $locationAcc
     * @return void
     */
    public function forceDeleted(LocationAcc $locationAcc)
    {
        //
    }
}
