<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeData extends Model
{
    protected $fillable = [
        'uID', 'start_time', 'end_time', 'mode', 'height',
    ];
    protected $table = 'timedata';
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
