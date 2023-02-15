<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VPin extends Model
{
    /**
     * @var string[]
     */
    protected $table = 'vpin_batch';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
