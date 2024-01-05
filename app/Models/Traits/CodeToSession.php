<?php

namespace App\Models\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Http;

trait CodeToSession
{
    public function kuaiShou($code, $program) // 快手小程序
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

    public function weappCodeToSession($program, $code = null) // 微信小程序
    {
        if ($program === 'yinghuochong') {
            $miniApp = app('wechat.mini_program.yinghuochong');
        } else if($program === 'sayunshang') {
            $miniApp = app('wechat.mini_program.sayunshang');
        } else if ($program === 'mengdatong') {
            $miniApp = app('wechat.mini_program.mengdatong');
        } else if($program === 'yinghuochong_new') {
            $miniApp = app('wechat.mini_program.yinghuochong_new');
        } else { // 谨耀商
            $miniApp = app('wechat.mini_program');
        }
        if (is_null($code)) {
            return $miniApp;
        }
        $response = $miniApp->auth->session($code);

        if (isset($response['errcode'])) {
            throw new AuthenticationException('code 不正确');
        }

        return $response;
    }
}
