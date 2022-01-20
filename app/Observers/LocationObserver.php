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
            'locationId' => $locationAcc->locationId ,
            'DID' => $locationAcc->DID ,
            'fullName' => $locationAcc->fullName ,
            'primaryAccPmaId' => $locationAcc->primaryAccPmaId,
            'paymentTypePayId' => $locationAcc->paymentTypePayId,
            'paymentType2PayId' => $locationAcc->paymentType2PayId,
            'username' => $locationAcc->username,
            'password' => $locationAcc->password,
            'locationName' => $locationAcc->locationName,
            'companyLegalName' => $locationAcc->companyLegalName,
            'dbServer' => $locationAcc->dbServer,
            'locationShort' => $locationAcc->locationShort,
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
        $uuid = Str::uuid()->toString();

        DB::table('locations_log')->insert([
            'locationId' => $locationAcc->locationId ,
            'DID' => $locationAcc->DID ,
            'fullName' => $locationAcc->fullName ,
            'primaryAccPmaId' => $locationAcc->primaryAccPmaId,
            'paymentTypePayId' => $locationAcc->paymentTypePayId,
            'paymentType2PayId' => $locationAcc->paymentType2PayId,
            'username' => $locationAcc->username,
            'password' => $locationAcc->password,
            'locationName' => $locationAcc->locationName,
            'companyLegalName' => $locationAcc->companyLegalName,
            'dbServer' => $locationAcc->dbServer,
            'locationShort' => $locationAcc->locationShort,
            'status' => $locationAcc->status,
        ]);
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
        $uuid = Str::uuid()->toString();

        DB::table('locations_log')->insert([
            'locationId' => $locationAcc->locationId ,
            'DID' => $locationAcc->DID ,
            'fullName' => $locationAcc->fullName ,
            'primaryAccPmaId' => $locationAcc->primaryAccPmaId,
            'paymentTypePayId' => $locationAcc->paymentTypePayId,
            'paymentType2PayId' => $locationAcc->paymentType2PayId,
            'username' => $locationAcc->username,
            'password' => $locationAcc->password,
            'locationName' => $locationAcc->locationName,
            'companyLegalName' => $locationAcc->companyLegalName,
            'dbServer' => $locationAcc->dbServer,
            'locationShort' => $locationAcc->locationShort,
            'status' => $locationAcc->status,
        ]);
    }
}
