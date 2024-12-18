<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preset extends Model
{
    protected $fillable = ['uID', 'name', 'height'];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
