<?php

namespace App\Http\Controllers;

use App\Models\Qun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QunsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Qun $qun
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Qun $qun, Request $request)
    {
        $program = $request->program;
        if ($program === 'yinghuochong') {
            $miniApp = app('wechat.mini_program.yinghuochong');
        } else if ($program === 'zhensheng') {
            $miniApp = app('wechat.mini_program.zhensheng');
        } else { // 谨耀商
            $miniApp = app('wechat.mini_program');
        }
        try {
            $access_token = $miniApp->access_token->getToken()['access_token'];
            $response = Http::post('https://api.weixin.qq.com/wxa/generatescheme?&access_token=' . $access_token,
                [
                    'jump_wxa' => [
                        'path' => '/pages/quns/show',
                        'query' => 'id=' . $qun->id,
                        'env_version' => 'release'
                    ],
                    'is_expire' => true,
                    'expire_type' => 1,
                    'expire_interval' => 1
                ]);
            $link = $response['openlink'];
        } catch (\Exception $exception) {
            $access_token = $miniApp->access_token->getToken(true)['access_token'];
            $response = Http::post('https://api.weixin.qq.com/wxa/generatescheme?&access_token=' . $access_token,
                [
                    'jump_wxa' => [
                        'path' => '/pages/quns/show',
                        'query' => 'id=' . $qun->id,
                        'env_version' => 'release'
                    ],
                    'is_expire' => true,
                    'expire_type' => 1,
                    'expire_interval' => 1
                ]);
            $link = $response['openlink'];
        }

        return view('quns.show', compact('qun', 'link', 'program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Qun $qun
     * @return \Illuminate\Http\Response
     */
    public function edit(Qun $qun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qun $qun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qun $qun)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Qun $qun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qun $qun)
    {
        //
    }
}
