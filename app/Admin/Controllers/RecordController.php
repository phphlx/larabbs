<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Record;
use App\Models\Salesperson;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class RecordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Record(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id')->display(function ($user_id) {
                $name = $this->user->email ?: $this->user->phone;
                return $user_id . ', ' . $this->user->name . ', ' . $name;
            });
            $grid->column('admin_id')->display(function ($admin_id) {
                $adminName = $this->admin ? $this->admin->username : '';
                return $admin_id . ', ' . $adminName;
            });
            $grid->column('money');
            $grid->column('salesperson_id')->display(function ($salesperson_id) {
                $name = $this->salesperson->name ?? '';
                return $salesperson_id . ', ' . $name;
            });
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->model()->orderByDesc('id')->with(['user', 'admin', 'salesperson']);

            $grid->disableBatchActions();
            $grid->disableActions();
            $grid->disableRowSelector();
            $grid->disableCreateButton();

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

                $admin = Admin::user()->pluck('name', 'id');
                $filter->where('管理员', function ($query) {
                    $query->whereHas('admin', function ($query) {
                        $query->where('id', $this->input);
                    });
                })->select($admin)->width(2);

                $salespeople = Salesperson::pluck('name', 'id');
                $filter->where('销售员', function ($query) {
                    $query->whereHas('salesperson', function ($query) {
                        $query->where('id', $this->input);
                    });
                })->select($salespeople)->width(2);

                $filter->where('开始', function ($query) {
                    $query->whereDate('created_at', '>=', $this->input);
                }, '开始')->width(2)->date();

                $filter->where('结束', function ($query) {
                    $query->whereDate('created_at', '<=', $this->input);
                }, '结束')->width(2)->date();

                $filter->where('上月', function ($query) {
                    $query->whereDate('created_at', '>=', now()->subMonth()->startOfMonth())->whereDate('created_at',
                        '<=', now()->subMonth()->endOfMonth());
                })->radio([1 => '是'])->width(0);
            });

            $grid->header(function ($collection) use ($grid) {
                $query = \App\Models\Record::query();

                // 拿到表格筛选 where 条件数组进行遍历
                $grid->model()->getQueries()->unique()->each(function ($value) use (&$query) {
                    if (in_array($value['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) {
                        return;
                    }

                    $query = call_user_func_array([$query, $value['method']], $value['arguments'] ?? []);
                });

                // 查出统计数据 lesson 这里思考了半天
                $todayQuery = clone $query;
                $weekQuery = clone $query;
                $monthQuery = clone $query;

                $totalMoney = $query->sum('money');
                $totalOrder = $query->count('id');
                $totalRefund = $query->where('money', '<=', 0)->sum('money');
                $totalRefundOrder = $query->count('id');

                $monthMoney = $monthQuery->whereDate('created_at', '>=', now()->startOfMonth())->sum('money');
                $monthOrder = $monthQuery->count('id');
                $monthRefund = $monthQuery->where('money', '<=', 0)->sum('money');
                $monthRefundOrder = $monthQuery->count('id');

                $weekMoney = $weekQuery->whereDate('created_at', '>=', now()->startOfWeek())->sum('money');
                $weekOrder = $weekQuery->count('id');
                $weekRefund = $weekQuery->where('money', '<=', 0)->sum('money');
                $weekRefundOrder = $weekQuery->count('id');

                $todayMoney = $todayQuery->whereDate('created_at', now())->sum('money');
                $todayOrder = $todayQuery->count('id');
                $todayRefund = $todayQuery->where('money', '<=', 0)->sum('money');
                $todayRefundOrder = $todayQuery->count('id');

                return <<<TEXT
                    <div class="panel panel-default pt-1">
                      <table class="table primary dark danger info secondary success warning">
                        <tr>
                            <td>本周:
                                <span class="badge-info">$weekMoney</span> $weekOrder
                                <span class="badge-secondary">$weekRefund</span> $weekRefundOrder
                            </td>
                            <td>本月:
                                <span class="badge-info">$monthMoney</span> $monthOrder
                                <span class="badge-secondary">$monthRefund</span> $monthRefundOrder
                            </td>
                            <td>今日:
                                <span class="badge-info">$todayMoney</span> $todayOrder
                                <span class="badge-secondary">$todayRefund</span> $todayRefundOrder
                            </td>
                            <td>总:
                                <span class="badge-success">$totalMoney</span> $totalOrder
                                <span class="badge-secondary">$totalRefund</span> $totalRefundOrder
                            </td>
                        </tr>
                      </table>
                    </div>
TEXT;
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

        return Show::make($id, new Record(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('admin_id');
            $show->field('money');
            $show->field('salesperson_id');
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
        return false;

        return Form::make(new Record(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('admin_id');
            $form->text('money');
            $form->text('salesperson_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
