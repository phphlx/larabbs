<?php

namespace App\Observers;

use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UserObserver
{
    public function saving(User $user)
    {
        // 这样写扩展性更高，只有空的时候才指定默认头像
        if (empty($user->avatar)) {
            $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/30/1/TrJS40Ey5k.png';
        }
    }

    public function updating(User $user)
    {
        $request_permissions_str = request()->permissions;
//        dump(1, $request_permissions_str);

        $request_permissions_arr = explode(',', $request_permissions_str);
//        dump(2, $request_permissions_arr);

        // 如果一次选择了两个权限 返回错误
        if (count($request_permissions_arr) > 1) {
            dump('错误, 选择了多个权限');
            die;
        }
        // 如果已有权限且两个权限不一样 返回错误
        $user_permissions_arr = $user->permissions()->pluck('id');
//        dump(3, $user_permissions_arr);
        if ($request_permissions_str && $user_permissions_arr->count() && $user_permissions_arr[0] != $request_permissions_arr[0]) {
            dump('错误, 权限不能修改');
            die;
        }
        // 开通权限 添加记录 更新用户记录
        if ($request_permissions_str && !$user_permissions_arr->count()) {
            if (request()->money <= 0) {
                dump('错误, 没有金额');
                die;
            }
//            dump(111);
            $permission = Permission::findById($request_permissions_str);
            Record::create([
                'user_id' => $user->id,
                'admin_id' => Auth::id(),
                'money' => request('money'),
            ]);
            $user->start_at = Carbon::now();
            $user->end_at = Carbon::now()->addDays($permission->day);
            $user->email = $user->email ?: null;
//            dump(4, $permission->day);
        }
        // 取消权限 添加记录
        if (!$request_permissions_str && $user_permissions_arr->count()) {
            if (request()->money > 0) {
                dump('错误, 金额不能大于 0');
                die;
            } else if (!is_null(request()->money) && request()->money <= 0) {
                Record::create([
                    'user_id' => $user->id,
                    'admin_id' => Auth::id(),
                    'money' => request('money'),
                ]);
                $user->start_at = null;
                $user->end_at = null;
                $user->email = $user->email ?: null;
                $user->money = null;
            }
        }

        if (!request('password')) {
            $user->password = $user->getOriginal('password');
        }
    }
}
