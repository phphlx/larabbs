<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\WeappAuthorizationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Overtrue\Socialite\AccessToken;
use Illuminate\Auth\AuthenticationException;
use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request)
    {
        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        $credentials['password'] = $request->password;

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            throw new AuthenticationException(trans('auth.failed'));
        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function socialStore($type, SocialAuthorizationRequest $request)
    {
        $driver = \Socialite::driver($type);

        try {
            if ($code = $request->code) {
                $accessToken = $driver->getAccessToken($code);
            } else {
                $tokenData['access_token'] = $request->access_token;

                // 微信需要增加 openid
                if ($type == 'wechat') {
                    $tokenData['openid'] = $request->openid;
                }
                $accessToken = new AccessToken($accessData);
            }

            $oauthUser = $driver->user($accessToken);
        } catch (\Exception $e) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }

        switch ($type) {
            case 'wechat':
                $unionid = $oauthUser->getOriginal()['unionid'] ?? null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }

        $token = auth('api')->login($user);

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function weappStore(WeappAuthorizationRequest $request)
    {
        $code = $request->code;

        // 根据 code 获取微信 openid 和 session_key
        if ($request->program === 'yinghuochong') {
            $miniApp = app('wechat.mini_program.yinghuochong');
        } else if ($request->program === 'zhensheng') {
            $miniApp = app('wechat.mini_program.zhensheng');
        } else { // 谨耀商
            $miniApp = app('wechat.mini_program');
        }
        $data = $miniApp->auth->session($code);

        // 如果结果错误, 说明 code 已过期或不正确, 返回 401 错误
        if (isset($data['errcode'])) {
            throw new AuthenticationException('code 不正确');
        }

        // 找到 openid 对应的用户
        $user = User::where('weapp_openid', $data['openid'])->first();
        $attributes['weixin_session_key'] = $data['session_key'];

        // 未找到对应用户则需要提交用户名密码进行用户绑定
        if (!$user) {
            // 如果未提交用户名密码, 403 错误提示
            if (!$request->username) {
                throw new AuthenticationException('用户不存在');
            }

            $username = $request->username;

            // 用户名可以是邮箱或者电话
            filter_var($username, FILTER_VALIDATE_EMAIL) ?
                $credentials['email'] = $username :
                $credentials['phone'] = $username;

            $credentials['password'] = $request->password;

            // 验证用户名密码是否正确
            if (!auth('api')->once($credentials)) {
                throw new AuthenticationException('用户名或密码错误');
            }

            // 获取对应的用户
            $user = auth('api')->getUser();
            $attributes['weapp_openid'] = $data['openid'];
        }

        // 更新用户数据
        $user->update($attributes);

        // 为对应用户创建 JWT
        $token = auth('api')->login($user);

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function tiktokStore(WeappAuthorizationRequest $request)
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

        // 找到 openid 对应的用户
        $user = User::where('tiktok_openid', $data['openid'])->first();
        $attributes['tiktok_session_key'] = $data['session_key'];

        if (!$user) { // 未找到对应用户则需要提交用户名密码进行用户绑定
            // 如果未提交用户名密码, 403 错误提示
            if (!$request->username) {
                throw new AuthenticationException('用户不存在');
            }

            $username = $request->username;
            // 用户名可以是邮箱或者电话
            filter_var($username, FILTER_VALIDATE_EMAIL) ?
                $credentials['email'] = $username :
                $credentials['phone'] = $username;

            $credentials['password'] = $request->password;

            // 验证用户名密码是否正确
            if (!auth('api')->once($credentials)) {
                throw new AuthenticationException('用户名或密码错误');
            }

            // 获取对应的用户
            $user = auth('api')->getUser();
            $attributes['tiktok_unionid'] = $data['unionid'];
            $attributes['tiktok_openid'] = $data['openid'];
        }

        // 更新用户数据
        $user->update($attributes);

        // 为对应用户创建 JWT
        $token = auth('api')->login($user);

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function update()
    {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        $user = auth('api')->user();
        if ($user) {
            $user->update(['weapp_openid' => null]);
        }
        auth('api')->logout();
        return response(null, 204);
    }

    public function tiktokDestroy()
    {
        $user = auth('api')->user();
        if ($user) {
            $user->update(['tiktok_openid' => null, 'tiktok_unionid' => null, 'tiktok_session_key' => null]);
        }
        auth('api')->logout();
        return response(null, 204);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
