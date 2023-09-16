<?php

namespace App\Models\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Http;

trait CodeToSession
{
    public function kuaiShou($code, $program)
    {
        if ($program === 'sanchaji2') { // 三叉戟快手第二个小程序
            $appid = config('kuaishou.sanchaji2.app_id');
            $secret = config('kuaishou.sanchaji2.secret');
        } else { // 三叉戟1
            $appid = config('kuaishou.sanchaji1.app_id');
            $secret = config('kuaishou.sanchaji1.secret');
        }

        $url = 'https://open.kuaishou.com/oauth2/mp/code2session';
        $response = Http::asForm()->post($url, [
            'app_id' => $appid,
            'app_secret' => $secret,
            'js_code' => $code
        ]);

        if (isset($response['error'])) { // 如果结果错误, 说明 code 已过期或不正确, 返回 401 错误
            throw new AuthenticationException('code 不正确');
        }

        return $response;
    }
}
