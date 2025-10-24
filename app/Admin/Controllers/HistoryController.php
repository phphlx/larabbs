<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\History;
use App\Models\Account;
use App\Models\History as HistoryModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Model;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class HistoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new History(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('account_id');
            $grid->column('trend');
            $grid->column('start_value');
            $grid->column('end_value');
            $grid->column('high')->display(function () {
                if ($this->high > 0.002) {
                    return "<span class='text-danger'>" . $this->high . '</span>';
                } else {
                    return $this->high;
                }
            });
            $grid->column('low');
            $grid->column('diff');
            $grid->column('last_value');
            $grid->column('max')->display(function () {
                if ($this->max > 0.005) {
                    return "<span class='text-danger'>". $this->max ."</span>";
                } else {
                    return $this->max;
                }
            });
            $grid->column('min');
            $grid->column('all_diff')->display(function () {
                if ($this->last_value > 0 && $this->start_value > 0) {
                    if ($this->trend === 'up') {
                        return round($this->last_value - $this->start_value, 4);
                    }
                    return round($this->start_value - $this->last_value, 4);
                }
            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->column('ended_at');

            $grid->model()->orderByDesc('id');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('account_id');
                $filter->equal('trend')->select(['up' => 'up', 'down' => 'down']);
                $filter->between('created_at', 'Created Time')->datetime();
            });

            $history = request('history');
            if ($history) {
                $grid->model()->whereNotNull('end_value');
            }
            $account_id = request('account_id');
            if ($account_id) {
                $grid->model()->where('account_id', $account_id);
            }

            $grid->footer(function ($collection) use ($grid) {
                $sum_up = 0;
                $sum_down = 0;
                $sum = 0;
                $account_id = request()->input('account_id');
                if ($account_id) {
                    $account = Account::find($account_id);
                    if ($account) {
                        $sum_up = $account->up_total_diff;
                        $sum_down = $account->down_total_diff;
                        $sum = $sum_up + $sum_down;
                    }
                }
                return "<div style='padding: 10px;'>涨: $sum_up, 跌: $sum_down, 总: $sum</div>";
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
        return Show::make($id, new History(), function (Show $show) {
            $show->field('id');
            $show->field('account_id');
            $show->field('start_value');
            $show->field('end_value');
            $show->field('diff');
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
        return Form::make(new History(), function (Form $form) {
            $form->display('id');
            $form->text('account_id');
            $form->text('start_value');
            $form->text('end_value');
            $form->text('diff');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function createUpdate()
    {
        $request = request();
        $account_id = $request->input('uid');
        $trend = $request->input('trend');
        $value = $request->input('price');
        $history = HistoryModel::where('account_id', $account_id)->where('end_value', null)->orderBy('id', 'desc')->first();
        if ($history) {
            $history->end_value = $value;
            if ($history->trend === Account::TREND_UP) {
                $history->diff = number_format($value - $history->start_value - 0.0007, 4);
            } else {
                $history->diff = number_format($history->start_value - $value - 0.0007, 4);
            }
            $history->high = $history->account->high;
            $history->low = $history->account->low;
            $history->save();
            $history->account()->update(['value' => 0, 'high' => 0, 'low' => 0]);
        } else {
            $history = HistoryModel::create([
                'account_id' => $account_id,
                'trend' => $trend,
                'start_value' => $value,
                'high' => 0,
                'low' => 0,
                'diff' => 0,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '添加成功',
        ]);
    }
}
