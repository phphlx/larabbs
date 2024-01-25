<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\ImageRequest;
use App\Models\Image;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader)
    {
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->qrcode) {
            // 保存图片到本地
            $result = $uploader->save($file, 'qrcode', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $image = auth()->user()->qrcode;
                if (!$image) {
                    $image = new Image();
                }
                $image->path = $result['path'];
                $image->type = $request->type;
                $image->user_id = auth()->id();
                $image->save();
                return back()->with('success', '上传 / 更新成功');
            }
            return back()->with('error', '上传失败, 请重试');
        }
    }

    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }
}
