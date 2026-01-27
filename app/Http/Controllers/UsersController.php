<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'generate']]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

    public function generate(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $code = 0;
        if ($id && $type) {
            $date = date('Y-m-d'); // 暂时刷新订单创建时间
            switch ($type) {
                case 0: // 购买时间, 生成时间
                    $code = base64_encode(md5($id . '2000') . $date . date('Y-m-d'));
                    break;
                case 1:
                    $code = base64_encode(md5($id . '2019') . $date . date('Y-m-d'));
                    break;
                case 2:
                    $code = base64_encode(md5($id . '2022') . $date . date('Y-m-d'));
                    break;
                case 3:
                    $code = base64_encode(md5($id . '2099') . $date . date('Y-m-d'));
                    break;
                default:
                    $code = 0;
                    break;
            }
        }

        return view('users.code', compact('code'));
    }
}
