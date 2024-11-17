<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeData extends Model
{
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
