<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

class Article extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = ['title', 'content', 'user_id'];

    public static function booted()
    {
        static::creating(function (Article $article) {
            $article->user_id = User::first()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
