<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $primaryKey = 'locationID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'contractID',
        'location_acc_locationID',
        'services_catalog_corpID',
        'fullName',
        'terms',
        'description',
        'amount',
        'num_month',
        'num_payments',
        'contract_body',
        'startDate',
        'endDate',
        'status',
        'signature',
    ];

    public function location()
    {
        return $this->belongsTo(LocationAcc::class);
    }
}
