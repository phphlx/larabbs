<?php

namespace App\Models;

class Record extends Model
{
    protected $fillable = ['user_id', 'money', 'start_at', 'end_at',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
