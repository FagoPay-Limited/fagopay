<?php

namespace App\Models;

use App\Models\User;
use App\Models\AdvertCatgeory;
use Illuminate\Database\Eloquent\Model;

class Billsbulk extends Model
{
    /**
     * @var string[]
     */
    protected $table = 'bills_bulk_jobs';

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
