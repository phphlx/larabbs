<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Qun extends Model
{
//    use HasDateTimeFormatter;

    protected $fillable = ['title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
