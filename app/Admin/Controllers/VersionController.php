<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Version;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class VersionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Version(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('用户名')->display(function () {
                return $this->user->name;
            });
            $grid->column('model_data')->display(function () {
                return '<div style="width: 1000px; overflow-wrap: break-word">' . $this->unserializeModel() . '</div>';
            });
            $grid->column('versionable_id', '删除id');
            $grid->column('versionable_type', '删除类型');
            $grid->column('title')->display(function () {
                return $this->unserializeModel()->title ?: $this->unserializeModel()->name;
            });
            $grid->column('intro')->display(function () {
                return $this->unserializeModel()->intro;
            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

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
        return Show::make($id, new Version(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('model_data');
            $show->field('versionable_id');
            $show->field('versionable_type');
            $show->field('title');
            $show->field('intro');
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
        return Form::make(new Version(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('model_data');
            $form->text('versionable_id');
            $form->text('versionable_type');
            $form->text('title');
            $form->text('intro');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
