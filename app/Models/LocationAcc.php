<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationAcc extends Model
{
    use HasFactory;

    protected $primaryKey = 'locationID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'locationID',
        'primary_acc_pmaID',
        'payment_type_payId',
        'username',
        'locationName',
        'companyLegalName',
        'dbDestination',
        'locationDestination'
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function primary_acc()
    {
        return $this->belongsTo(PrimaryAcc::class);
    }

    public function payment()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
