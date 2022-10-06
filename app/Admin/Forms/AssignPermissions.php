<?php

namespace App\Admin\Forms;

use App\Models\Record;
use Carbon\Carbon;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Spatie\Permission\Models\Permission;

class AssignPermissions extends Form
{
    use LazyWidget;

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $user_id = $this->payload['id'] ?? null;
        $permissions_id = $input['permissions_id'];
        $money = $input['money'];
        $salesperson_id = $input['salesperson_id'];

        $user = \App\Models\User::find($user_id);
        if ($user->isMember()) {
            return $this->response()
                ->error('当前会员还在有效期内, 不可重复开通.');
        }
        $permissions = Permission::findById($permissions_id);
        $user->givePermissionTo($permissions->name);
        Record::create([
            'user_id' => $user_id,
            'admin_id' => \Admin::user()->id,
            'salesperson_id' => $salesperson_id,
            'money' => $money
        ]);
        $user->money = $money;
        $user->start_at = Carbon::now();
        $user->end_at = Carbon::now()->addDays($permissions->day);

        $user->save();

        return $this
            ->response()
            ->success('Processed successfully.')
            ->refresh();
    }

    /**
     * Build a form here.
     * lesson 预加载卡住了好久哇
     */
    public function form()
    {
        $this->select('salesperson_id', '销售员')->options($this->payload['salespeople'])->required();
        $this->select('permissions_id', '权限')->options($this->payload['permissions'])->required();
        $this->text('money')->required()->rules('gt:0');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'name' => 'John Doe',
            'email' => 'John.Doe@gmail.com',
        ];
    }
}
