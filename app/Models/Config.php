<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasDateTimeFormatter;

    // 1 群平台引流设置
    // 2 精准客源平台
    // 3 wechat推广页面
}
