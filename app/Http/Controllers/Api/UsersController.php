<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => $request->password,
        ]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return (new UserResource($user))->showSensitiveFields();
    }

    public function weappStore(UserRequest $request)
    {
        // 获取微信的 openid 和 session_key
        if ($request->program === 'yinghuochong') {
            $miniApp = app('wechat.mini_program.yinghuochong');
        } else if ($request->program === 'zhensheng') {
            $miniApp = app('wechat.mini_program.zhensheng');
        } else { // 谨耀商
            $miniApp = app('wechat.mini_program');
        }
        $data = $miniApp->auth->session($request->code);

        if (isset($data['errcode'])) {
            throw new AuthenticationException('code 不正确');
        }

        // 如果 openid 对应的用户已存在，报错403
        $user = User::where('weapp_openid', $data['openid'])->first();

        if ($user) {
            throw new AuthenticationException('微信已绑定其他用户，请直接登录');
        }

        // 创建用户
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'weapp_openid' => $data['openid'],
            'weixin_session_key' => $data['session_key'],
        ]);

        return (new UserResource($user))->showSensitiveFields();
    }

    public function tiktokStore(UserRequest $request)
    {
        $code = $request->code;

        $appid = config('tiktok.tiktok.app_id');
        $secret = config('tiktok.tiktok.secret');

        $url = 'https://developer.toutiao.com/api/apps/v2/jscode2session';

        $response = Http::post($url, [
            'appid' => $appid,
            'secret' => $secret,
            'code' => $code
        ]);
        // 如果结果错误, 说明 code 已过期或不正确, 返回 401 错误
        if ($response['err_no']) {
            throw new AuthenticationException('code 不正确');
        }
        $data = $response['data'];

        // 如果 openid 对应的用户已存在，报错403
        $user = User::where('tiktok_openid', $data['openid'])->first();
        if ($user) {
            throw new AuthenticationException('此抖音已绑定其他用户，请直接登录');
        }

        try {
            $user = User::create([ // 创建用户
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->username,
                'password' => $request->password,
                'tiktok_openid' => $data['openid'],
                'tiktok_unionid' => $data['unionid'],
                'tiktok_session_key' => $data['session_key'],
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                throw new AuthenticationException('邮箱已存在, 请直接登录');
            }
        }

        return (new UserResource($user))->showSensitiveFields();
    }

    public function show(User $user, Request $request)
    {
        return new UserResource($user);
    }

    public function me(Request $request)
    {
        return (new UserResource($request->user()))->showSensitiveFields();
    }

    public function update(UserRequest $request)
    {
        $user = $request->user();

        $attributes = $request->only(['name', 'email', 'phone', 'password', 'introduction', 'registration_id']);
        if (!$request->email) {
            unset($attributes['name']);
        }

        if ($request->password) {
            $attributes['password'] = bcrypt($request->password);
        }

        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }

        $user->update($attributes);

        return (new UserResource($user))->showSensitiveFields();
    }

    public function activedIndex(User $user)
    {
        UserResource::wrap('data');
        return UserResource::collection($user->getActiveUsers());
    }
}
