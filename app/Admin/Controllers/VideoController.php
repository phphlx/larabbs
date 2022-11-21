<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Video;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class VideoController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Video(['user']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id')->display(function ($user_id) {
                return $user_id . ', ' . $this->user->name;
            });
            $grid->column('title');
            $grid->column('video')->display(function ($video) {
                return '<video src="' . $video . '" class="video" controls style="max-width: 140px;"></video>';
            });
            $grid->column('intro');
            $grid->column('qrcode')->image('qrcode', 60, 60);
            $grid->column('link')->display(function ($link) {
                return "<div style='width: 160px; overflow: auto;'>$link</div>";
            });
            $grid->column('btn_text')->display(function ($btn_text) {
                return "<div style='width: 160px; overflow: auto;'>$btn_text</div>";
            });
            $grid->column('share_title')->display(function ($share_title) {
                return "<div style='width: 160px; overflow: auto;'>$share_title</div>";
            });;
            $grid->column('share_img')->image('share_img', 60, 60);
            $grid->column('ad_title');
            $grid->column('ad_content');
            $grid->column('updated_at')->sortable();

            $grid->model()->orderByDesc('id');
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->disableViewButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->expand();
                $filter->where('用户', function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%")
                            ->orWhere('email', 'like', "%{$this->input}%")
                            ->orWhere('phone', 'like', "%{$this->input}%")
                            ->orWhere('title', 'like', "%{$this->input}%");
                    });
                })->placeholder('输入用户名, 邮箱, 手机号, 标题')->width(2);
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
        return Show::make($id, new Video(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('title');
            $show->field('video');
            $show->field('intro');
            $show->field('qrcode');
            $show->field('time');
            $show->field('type');
            $show->field('link');
            $show->field('btn_text');
            $show->field('share_title');
            $show->field('share_img');
            $show->field('ad_title');
            $show->field('ad_content');
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
        return Form::make(new Video(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('title');
            $form->text('video');
            $form->text('intro');
            $form->text('qrcode');
            $form->text('time');
            $form->text('type');
            $form->text('link');
            $form->text('btn_text');
            $form->text('share_title');
            $form->text('share_img');
            $form->text('ad_title');
            $form->text('ad_content');

            $form->display('created_at');
            $form->display('updated_at');

            $form->disableViewButton();
        });
    }
}
