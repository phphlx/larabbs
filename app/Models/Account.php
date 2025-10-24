<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'account';

    protected $fillable = ['appid', 'secret', 'state', 'trend', 'value', 'high', 'low', 'pid'];

    const STATE_START = "start";
    const STATE_END = "end";

    const TREND_UP = "up";
    const TREND_DOWN = "down";

    public static $stateMap = [
        self::STATE_START => "开始",
        self::STATE_END => "结束",
    ];

    public static $trendMap = [
        self::TREND_UP => "上涨",
        self::TREND_DOWN => "下跌",
    ];

    /**
     * 关联历史记录
     */
    public function histories()
    {
        return $this->hasMany(History::class, 'account_id');
    }

    /**
     * 关联最新的一条历史记录
     */
    public function latestHistory()
    {
        return $this->hasOne(History::class, 'account_id')->latest();
    }

    /**
     * 获取所有历史记录的diff总和（带缓存优化）
     */
    public function getTotalDiffAttribute()
    {
        // 如果已经通过子查询加载了该属性，直接返回
        if (isset($this->attributes['total_diff_calculated'])) {
            return $this->attributes['total_diff_calculated'];
        }

        // 否则使用短时间缓存（5秒），减少数据库压力
        return \Cache::remember("account_{$this->id}_total_diff", 6, function() {
            return $this->histories()->sum('diff');
        });
    }

    public function getUpTotalDiffAttribute()
    {
        // 如果已经通过子查询加载了该属性，直接返回
        if (isset($this->attributes['up_total_diff_calculated'])) {
            return $this->attributes['up_total_diff_calculated'];
        }

        // 否则使用短时间缓存（5秒）
        return \Cache::remember("account_{$this->id}_up_total_diff", 6, function() {
            return $this->histories()->where('trend', 'up')->sum('diff');
        });
    }

    public function getDownTotalDiffAttribute()
    {
        // 如果已经通过子查询加载了该属性，直接返回
        if (isset($this->attributes['down_total_diff_calculated'])) {
            return $this->attributes['down_total_diff_calculated'];
        }

        // 否则使用短时间缓存（5秒）
        return \Cache::remember("account_{$this->id}_down_total_diff", 6, function() {
            return $this->histories()->where('trend', 'down')->sum('diff');
        });
    }

    public function getRecordTrendAttribute()
    {
        // 如果已经通过关联加载，直接返回
        if (isset($this->attributes['record_trend_calculated'])) {
            return $this->attributes['record_trend_calculated'];
        }

        // 使用短时间缓存
        return \Cache::remember("account_{$this->id}_record_trend", 6, function() {
            $history = $this->histories()->whereNull('ended_at')->latest()->first();
            return $history ? $history->trend : null;
        });
    }
}
