<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'history';

    protected $fillable = ['account_id', 'trend', 'start_value', 'end_value', 'high', 'low', 'diff', 'created_at', 'updated_at', 'min', 'max', 'last_value',
        'ended_at'];

    /**
     * 关联历史记录
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
