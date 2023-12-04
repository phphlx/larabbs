<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Salesperson;
use App\Models\Record;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class SalespersonController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Salesperson(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->model()->where('enable', 1);

            $grid->disableRowSelector();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->disableViewButton();

            $records = Record::groupBy('salesperson_id')->pluck('salesperson_id');
            $grid->actions(function (Grid\Displayers\Actions $actions) use ($records) {
                if ($records->contains($this->id)) {
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
        return Show::make($id, new Salesperson(), function (Show $show) {
            $show->field('id');
            $show->field('name');
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
        return Form::make(new Salesperson(), function (Form $form) {
            if ($form->model()->id && $form->model()->records()->exists()) {
                admin_error('当前销售员有销售记录, 不可修改 / 删除');
                $form->disableSubmitButton();
                $form->disableDeleteButton();
            }

            $form->display('id');
            $form->text('name');

            $form->display('created_at');
            $form->display('updated_at');

            $form->disableViewButton();
        });
    }
}
