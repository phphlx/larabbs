<?php

namespace App\Handlers;

use Image;
use Str;

class VideoUploadHandler
{
    protected $allowed_ext = ['avi', 'wmv', 'mpeg', 'mp4', 'm4v', 'mov', 'asf', 'flv', 'f4v', 'rmvb', 'rm', '3gp', 'vob',];

    //上传视频
    public function save($file, $folder, $file_prefix, $max_size = false)
    {
        $folder_name = "uploads/videos/$folder/" . date("Ym/d");

        $upload_path = public_path() . '/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'mp4';

        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . "/$folder_name/$filename",
        ];
    }
}
