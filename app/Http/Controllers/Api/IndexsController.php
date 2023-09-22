<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Queries\QunQuery;
use App\Http\Requests\Api\QunRequest;
use App\Http\Resources\QunResource;
use App\Models\Qun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IndexsController extends Controller
{
    public function search(Request $request) // 天气查询 // 需要设置 ip 白名单
    {
        $data = config('adcode');
        $adcode = 110000;
        if (array_key_exists($request->name, $data)) {
            $adcode = $data[$request->name];
        }

        $result = Http::get('https://restapi.amap.com/v3/weather/weatherInfo?key=1e23c4eb5c9bed348fabf40dcc6e91ba&city=' . $adcode);
        return response()->json($result['lives'][0]);
    }

    public function randomSentence()
    {
        $result = Http::get('https://api.gmit.vip/Api/YiYan');
        return response()->json($result->json());
    }

    public function cloudMusicComment()
    {
        $result = Http::get('https://api.gmit.vip/Api/HotComments');
        return response()->json($result->json());
    }
}
