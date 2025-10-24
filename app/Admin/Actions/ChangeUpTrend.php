<?php

namespace App\Admin\Actions;

use App\Models\Account;
use App\Models\Account as AccountModel;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ChangeUpTrend extends Action
{
    /**
     * @return string
     */
	protected $title = '<span class="btn btn-success">一键上涨</span>';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $accounts = Account::all();
        foreach ($accounts as $account) {
            if ($account->id === 1) { // todo 硬编码...
                continue;
            }
            if ($account->id === 1400) { // todo 硬编码...
                continue;
            }
            if ($account->id === 1411) { // todo 硬编码...
                continue;
            }
            if ($account->id === 1888) { // todo 硬编码...
                continue;
            }
            if ($account->id === 1999) { // todo 硬编码...
                continue;
            }
            $account->trend = AccountModel::TREND_UP;
            $account->save();
            (new \App\Admin\Controllers\AccountController)->updateConfigFile($account);
            // 记录日志，方便调试
            \Log::info("账户 {$account->id} 趋势已切换为: {$account->trend}，配置文件已更新");
        }
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        // return ['Confirm?', 'contents'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
