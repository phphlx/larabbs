<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Salesperson extends Model
{
//    use HasDateTimeFormatter;

    protected $fillable = ['name'];

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
