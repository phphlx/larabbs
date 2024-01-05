<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

class Article extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
