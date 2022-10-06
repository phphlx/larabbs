<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\AssignPermissions;
use App\Admin\Repositories\User;
use App\Models\Salesperson;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;
use Spatie\Permission\Models\Permission;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('phone');
            $grid->column('email');
            $grid->column('permissions')->display(function ($permissions) {
                $str = '';
                foreach ($permissions as $permission) {
                    $str .= "<a href='" . admin_route('users.index') . "?permissions[id]={$permission->id}'>
<span>{$permission->name}</span></a>" . PHP_EOL;
                }
                return $str;
            });
            $grid->column('start_at');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->model()->orderByDesc('id')->with('permissions');
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->disableFilterButton();
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableRowSelector();
            $grid->disableBatchActions();

            $permissions = Permission::pluck('name', 'id');
            $salespeople = Salesperson::pluck('name', 'id');
            $grid->actions(function (Grid\Displayers\Actions $actions) use ($permissions, $salespeople) {
                $actions->prepend(new AssignPermissions(['permissions' => $permissions, 'salespeople' => $salespeople]));
                $actions->append('<a class="btn btn-sm btn-secondary" href="'
                    . admin_route('users.edit', [$this->getKey()]) . '"><i class="fa fa-edit"></i></a>');
            });

            $grid->filter(function (Grid\Filter $filter) use ($permissions) {
                $filter->panel();
                $filter->expand();
                $filter->where('用户查询', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                        ->orWhere('email', 'like', "%{$this->input}%")
                        ->orWhere('phone', 'like', "%{$this->input}%");
                })->placeholder('输入, 姓名, 邮箱 或 手机号')->width(2);
                $filter->equal('permissions.id', '权限')->select($permissions)->width(2);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return false;
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('phone');
            $show->field('email');
            $show->field('money');
            $show->field('start_at');
            $show->field('end_at');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new User(), function (Form $form) {

            $form->display('id');
            $form->text('name')->rules(function (Form $form) {
                return 'required';
            });
            $form->text('phone')->rules(function (Form $form) {
                if (!$id = $form->model()->id) {
                    return ['unique:users,phone', 'nullable', 'digits:11'];
                }
                return ['unique:users,phone,' . $form->model()->id, 'nullable', 'digits:11'];
            });
            $form->text('email')->rules(function (Form $form) {
                if (!$id = $form->model()->id) {
                    return ['unique:users,email', 'required_without:phone', 'nullable', 'email'];
                }
                return ['unique:users,email,' . $form->model()->id, 'email', 'required_without:phone', 'nullable'];
            });
            $form->text('password')->rules(function (Form $form) {
                if (!$id = $form->model()->id) {
                    return 'required|min:6';
                }
                return 'nullable|min:6';
            });
            $form->text('weapp_openid')->placeholder('输入 weapp_id, 可不填');

            $form->display('created_at');
            $form->display('updated_at');

            $form->disableViewButton();
            $form->disableDeleteButton();
        });
    }
}
