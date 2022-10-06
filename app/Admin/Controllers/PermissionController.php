<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Permission;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class PermissionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Permission(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('guard_name');
            $grid->column('day');
            $grid->column('created_at')->toDateTimeString();
            $grid->column('updated_at')->sortable()->toDateTimeString();

            $grid->disableRowSelector();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->disableViewButton();

            // lesson 这里耽误时间了
            $permissions = \Spatie\Permission\Models\Permission::WhereHas('users')->pluck('id');
            $grid->actions(function (Grid\Displayers\Actions $actions) use ($permissions) {
                if ($permissions->contains($this->id)) {
                    $actions->disableEdit();
                    $actions->disableDelete();
                }
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new Permission(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('guard_name');
            $show->field('day');
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
        return Form::make(new Permission(), function (Form $form) {
            if ($form->model()->id && $form->model()->users()->exists()) {
                admin_error('当前权限内有用户, 不可修改 / 删除');
                $form->disableSubmitButton();
                $form->disableDeleteButton();
            }

            $form->display('id');
            $form->text('name');
            $form->text('guard_name');
            $form->text('day');

            $form->display('created_at');
            $form->display('updated_at');

            $form->disableViewButton();
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $permissions = \Spatie\Permission\Models\Permission::findById($id);

        if ($permissions->users()->exists()) {
            return $this->form()->response()->error('当前权限内有用户, 不可修改 / 删除');
        }

        return $this->form()->update($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissions = \Spatie\Permission\Models\Permission::findById($id);

        if ($permissions->users()->exists()) {
            return $this->form()->response()->error('当前权限内有用户, 不可修改 / 删除');
        }

        return $this->form()->destroy($id);
    }
}
