<?php

namespace App\Observers;

use App\Models\PaymentType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaymentObserver
{
    /**
     * Handle the PaymentType "created" event.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return void
     */
    public function created(PaymentType $paymentType)
    {
        //
    }

    /**
     * Handle the PaymentType "updated" event.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return void
     */
    public function updated(PaymentType $paymentType)
    {
        $uuid = Str::uuid()->toString();

        DB::table('payment_types_logs')->insert([
            'payId' => $paymentType->payId ,
            'primaryAccPmaId' => $paymentType->primaryAccPmaId ,
            'fullName' => $paymentType->fullName ,
            'ccn' => $paymentType->ccn,
            'address' => $paymentType->address,
            'address2' => $paymentType->address2,
            'exMonth' => $paymentType->exMonth,
            'exYear' => $paymentType->exYear,
            'city' => $paymentType->city,
            'state' => $paymentType->state,
            'ccv' => $paymentType->ccv,
            'zip' => $paymentType->zip,
            'phone' => $paymentType->phone,
            'cardType' => $paymentType->cardType,
            'status' => $paymentType->status,
            'action' => 'updated',
        ]);
    }

    /**
     * Handle the PaymentType "deleted" event.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return void
     */
    public function deleted(PaymentType $paymentType)
    {
        $uuid = Str::uuid()->toString();

        DB::table('payment_types_logs')->insert([
            'payId' => $paymentType->payId ,
            'primaryAccPmaId' => $paymentType->primaryAccPmaId ,
            'fullName' => $paymentType->fullName ,
            'ccn' => $paymentType->ccn,
            'address' => $paymentType->address,
            'address2' => $paymentType->address2,
            'exMonth' => $paymentType->exMonth,
            'exYear' => $paymentType->exYear,
            'city' => $paymentType->city,
            'state' => $paymentType->state,
            'ccv' => $paymentType->ccv,
            'zip' => $paymentType->zip,
            'phone' => $paymentType->phone,
            'cardType' => $paymentType->cardType,
            'status' => $paymentType->status,
            'action' => 'delete',
        ]);
    }

    /**
     * Handle the PaymentType "restored" event.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return void
     */
    public function restored(PaymentType $paymentType)
    {
        //
    }

    /**
     * Handle the PaymentType "force deleted" event.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return void
     */
    public function forceDeleted(PaymentType $paymentType)
    {
        //
    }
}
