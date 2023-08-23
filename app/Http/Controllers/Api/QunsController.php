<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Queries\QunQuery;
use App\Http\Requests\Api\QunRequest;
use App\Http\Resources\QunResource;
use App\Models\Qun;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function userIndex(Request $request, User $user, QunQuery $query)
    {
        $from = $request->from ?: 0;
        $quns = $query->where('user_id', $user->id)->where('from', $from)->paginate();

        return QunResource::collection($quns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return QunResource
     */
    public function store(QunRequest $request, Qun $qun)
    {
        $this->authorize('store', $qun);

        $qun->name = $request->name;
        $qun->intro = $request->intro;
        $qun->type = $request->type;
        $qun->avatar = $request->avatar[0]['url'];
        $qun->qrcode = $request->qrcode[0]['url'];
        $qun->num = $request->num;
        $qun->btn_text = $request->btnText;
        $qun->share_title = $request->shareTitle;
        $qun->share_img = $request->shareImg[0]['url'];
        $qun->user_id = $request->user()->id;
        $qun->from = $request->from;
        $qun->save();

        return new QunResource($qun);
    }

    /**
     * Display the specified resource.
     *
     * @param $qunId
     * @param QunQuery $query
     * @return QunResource
     */
    public function show($qunId, QunQuery $query)
    {
        $qun = $query->findOrFail($qunId);
        return new QunResource($qun);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return QunResource
     */
    public function update(QunRequest $request, Qun $qun)
    {
        $this->authorize('update', $qun);

        $qun->name = $request->name;
        $qun->intro = $request->intro;
        $qun->type = $request->type;
        $qun->avatar = $request->avatar[0]['url'];
        $qun->qrcode = $request->qrcode[0]['url'];
        $qun->num = $request->num;
        $qun->btn_text = $request->btnText;
        $qun->share_title = $request->shareTitle;
        $qun->share_img = $request->shareImg[0]['url'];
        $qun->user_id = $request->user()->id;
        $qun->save();

        return new QunResource($qun);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qun $qun)
    {
        $this->authorize('destroy', $qun);

        $qun->delete();

        return response(null, 204);
    }
}