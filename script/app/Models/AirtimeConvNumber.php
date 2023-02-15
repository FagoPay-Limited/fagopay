<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirtimeConvNumber extends Model
{
    protected $table = 'airtime_conv_numbers';
    protected $guarded = ['id'];
 
    public function network()
    {
        return $this->belongsTo(Network::class);
    }
   
    public function scopePending()
    {
        return $this->where('status', 0);
    }
}
