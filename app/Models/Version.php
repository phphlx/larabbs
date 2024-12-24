<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = ['user_id', 'model_data'];

    public function versionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unserializeModel()
    {
        return unserialize($this->attributes['model_data']);
    }
}
