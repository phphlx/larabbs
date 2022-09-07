<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qun extends Model
{
    protected $fillable = ['title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
