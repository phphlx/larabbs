<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Qun;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class QunController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Qun(['user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id')->display(function ($user_id) {
                return $user_id . ', ' . $this->user->name;
            });
            $grid->column('name');
            $grid->column('intro');
            $grid->column('avatar')->image('avatar', 60, 60);
            $grid->column('qrcode')->image('qrcode', 60, 60);
            $grid->column('num');
            $grid->column('share_title');
            $grid->column('share_img')->image('share_img', 60, 60);
            // lesson 宽度怎么设置的?
            $grid->column('btn_text')->display(function ($btn_text) {
                return "<div style='width: 160px; overflow: auto;'>$btn_text</div>";
            });
            $grid->column('updated_at')->sortable();

            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->model()->orderByDesc('id');
            $grid->disableViewButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->expand();
                $filter->where('用户', function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%")
                            ->orWhere('email', 'like', "%{$this->input}%")
                            ->orWhere('phone', 'like', "%{$this->input}%");
                    });
                })->placeholder('输入用户名, 邮箱, 手机号')->width(2);
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
        return Show::make($id, new Qun(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('name');
            $show->field('intro');
            $show->field('type');
            $show->field('avatar');
            $show->field('qrcode');
            $show->field('num');
            $show->field('share_title');
            $show->field('share_img');
            $show->field('btn_text');
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
        return Form::make(new Qun(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('name');
            $form->text('intro');
            $form->text('type');
            $form->text('avatar');
            $form->text('qrcode');
            $form->text('num');
            $form->text('share_title');
            $form->text('share_img');
            $form->text('btn_text');

            $form->display('created_at');
            $form->display('updated_at');

            $form->disableViewButton();
        });
    }
}
