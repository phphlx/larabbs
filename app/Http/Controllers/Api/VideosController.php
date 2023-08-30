<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Queries\VideoQuery;
use App\Http\Requests\Api\VideoRequest;
use App\Http\Resources\VideoResource;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(VideoQuery $query)
    {
        $videos = $query->paginate();

        return VideoResource::collection($videos);
    }

    public function userIndex(Request $request, User $user, VideoQuery $query)
    {
        $from = $request->from ?: 0;
        $videos = $query->where([['user_id', $user->id], ['from', $from]])->paginate();

        return VideoResource::collection($videos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return VideoResource
     */
    public function store(VideoRequest $request, Video $video)
    {
        $this->authorize('store', $video);

        $video->title = $request->title;
        $video->video = $request->video[0]['url'];
        $video->ad_title = $request->adTitle;
        $video->ad_content = $request->adContent;
        $video->intro = $request->intro;
        $video->qrcode = $request->qrcode[0]['url'];
        $video->time = $request->time;
        $video->type = $request->type;
        $video->link = $request->link;
        $video->btn_text = $request->btnText;
        $video->share_title = $request->shareTitle;
        $video->share_img = $request->shareImg[0]['url'];
        $video->user_id = $request->user()->id;
        $video->from = $request->from ?: 0;
        $video->save();

        return new VideoResource($video);
    }

    /**
     * Display the specified resource.
     *
     * @param $videoId
     * @param VideoQuery $query
     * @return VideoResource
     */
    public function show($videoId, VideoQuery $query)
    {
        $video = $query->findOrFail($videoId);
        return new VideoResource($video);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return VideoResource
     */
    public function update(VideoRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $video->title = $request->title;
        $video->video = $request->video[0]['url'];
        $video->ad_title = $request->adTitle;
        $video->ad_content = $request->adContent;
        $video->intro = $request->intro;
        $video->qrcode = $request->qrcode[0]['url'];
        $video->time = $request->time;
        $video->type = $request->type;
        $video->link = $request->link;
        $video->btn_text = $request->btnText;
        $video->share_title = $request->shareTitle;
        $video->share_img = $request->shareImg[0]['url'];
        $video->user_id = $request->user()->id;
        $video->from = $request->from ?: 0;
        $video->save();

        return new VideoResource($video);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $this->authorize('destroy', $video);

        $video->delete();

        return response(null, 204);
    }
}
