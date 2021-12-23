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
        'payId','primaryAccPmaId','fullName','ccn','exMonth','exYear', 
        'ccv', 'phone', 'cardType', 'address','address2', 'city', 'state', 'zip', 'status'
    ];

    public function primary_acc()
    {
        return $this->belongsTo(PrimaryAcc::class);
    }

    public function locations()
    {
        return $this->hasMany(LocationAcc::class, 'paymentTypePayId', 'payId');
    }

    public function locationsBackUp()
    {
        return $this->hasMany(LocationAcc::class, 'paymentType2PayId', 'payId');
    }
    
}
