<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $primaryKey = 'payId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'payId','primary_acc_pmaID','fullName','ccn','exMonth','exYear', 
        'ccv', 'cardType', 'address','address2', 'city', 'state', 'zip' 
    ];

    public function primary_acc()
    {
        return $this->belongsTo(PrimaryAcc::class);
    }

    public function locations()
    {
        return $this->hasMany(LocationAcc::class);
    }
    
}
