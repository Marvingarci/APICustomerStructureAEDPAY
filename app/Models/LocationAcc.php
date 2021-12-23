<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationAcc extends Model
{
    use HasFactory;

    protected $primaryKey = 'locationId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'locationId',
        'DID',
        'primaryAccPmaId',
        'paymentTypePayId',
        'paymentType2PayId',
        'fullName',
        'username',
        'password',
        'locationName',
        'companyLegalName',
        'dbServer',
        'locationShort',
        'status',
    ];

    public function contract()
    {
        return $this->hasMany(Contract::class, 'locationAccLocationId', 'locationId');
    }

    public function primary_acc()
    {
        return $this->belongsTo(PrimaryAcc::class, 'pmaId', 'primaryAccPmaId' );
    }

    public function payment()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
