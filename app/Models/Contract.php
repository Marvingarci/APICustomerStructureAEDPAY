<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $primaryKey = 'contractId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'contractId',
        'locationAccLocationId',
        'servicesCatalogCorpId',
        'fullName',
        'terms',
        'description',
        'amount',
        'numMonth',
        'numPayments',
        'contractBody',
        'startDate',
        'endDate',
        'status',
        'signature',
    ];

    public function location()
    {
        return $this->belongsTo(LocationAcc::class, 'locationId', 'locationAccLocationId');
    }
}
