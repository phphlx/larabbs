<?php

namespace App\Models;

use App\Models\Traits\Versionable;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasDateTimeFormatter, Versionable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getVideoAttribute()
    {
        return str_replace(['op.sanchaji19.com', 'xcx.sanchaji520.com'], 'xcx.gongzhonghaoxifen.com',
            $this->attributes['video']);
    }

    public function getQrcodeAttribute()
    {
        return str_replace(['op.sanchaji19.com', 'xcx.sanchaji520.com'], 'xcx.gongzhonghaoxifen.com',
            $this->attributes['qrcode']);
    }

    public function getShareImgAttribute()
    {
        return str_replace(['op.sanchaji19.com', 'xcx.sanchaji520.com'], 'xcx.gongzhonghaoxifen.com',
            $this->attributes['share_img']);
    }
}
