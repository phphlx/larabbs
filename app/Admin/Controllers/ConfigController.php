<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Config;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ConfigController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Config(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('share_title');
            $grid->column('link');
            $grid->column('share_img')->image('', 60);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
            });
            $grid->disableBatchActions();
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
        return Show::make($id, new Config(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('link');
            $show->field('share_title');
            $show->field('share_img')->image();
            $show->field('created_at');
            $show->field('updated_at');
            $show->disableDeleteButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Config(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('link');
            $form->text('share_title');
            $form->image('share_img');

            $form->display('created_at');
            $form->display('updated_at');
            $form->disableDeleteButton();
        });
    }
}
