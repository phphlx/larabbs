<?php

namespace App\Models;

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class Record extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = ['user_id', 'admin_id', 'money', 'start_at', 'end_at', 'salesperson_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function salesperson()
    {
        return $this->belongsTo(Salesperson::class);
    }
}
