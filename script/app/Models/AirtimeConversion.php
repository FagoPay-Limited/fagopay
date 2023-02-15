<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirtimeConversion extends Model
{
    protected $table = 'airtime_conversions';
    protected $guarded = ['id'];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function scopePending()
    {
        return $this->where('status', 0);
    }
}
