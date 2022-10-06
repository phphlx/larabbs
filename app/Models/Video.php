<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasDateTimeFormatter;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
