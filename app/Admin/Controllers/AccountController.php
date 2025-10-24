<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ChangeDownTrend;
use App\Admin\Actions\ChangeUpTrend;
use App\Admin\Repositories\Account;
use App\Models\Account as AccountModel;
use App\Models\History;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

class AccountController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Account(), function (Grid $grid) {
            // 启用自动刷新，每1秒刷新一次
            $grid->disableRefreshButton(false);

            $grid->column('id')->sortable();
            $grid->column('appid');
            // $grid->column('secret');
//            $grid->column('状态')->display(function () {
//                $class = $this->state == AccountModel::STATE_START ? 'text-success' : 'text-danger';
//                $text = AccountModel::$stateMap[$this->state] ?? '未知状态';
//                return "<span class=\"$class\">$text</span>";
//            });
            $grid->column('交易')->display(function () {
                $class = $this->trade == AccountModel::STATE_START ? 'text-success h1 text-bold' : 'text-danger h1 text-bold';
                $text = AccountModel::$stateMap[$this->trade] ?? '未知';
                return "<span class=\"$class\">$text</span>";
            });
            $grid->column('买卖trend')->display(function () {
                $class = $this->trend == AccountModel::TREND_UP ? 'text-success h1 text-bold' : 'text-danger h1 text-bold';
//                $text = AccountModel::$trendMap[$this->trend] ?? '涨跌';
                return "<span class='trend $class' data-id='$this->id'>$this->trend</span>";
            });
            $grid->column('记录趋势')->display(function () {
                $text = 'none';
                return "<span class='record-trend h1 text-bold text-success' data-id='" . $this->id . "'>$text</span>";
            });
            $grid->column('value', '当前值')->display(function () {
                return '<span class="text-success h1 text-bold account-value" data-id="' . $this->id . '">' . number_format($this->value, 4) . '</span>';
            });
            $grid->column('max', '最大值')->display(function () {
                return '<span class="text-success h1 text-bold account-max" data-id="' . $this->id . '">' . number_format($this->high, 4) . '</span>';
            });
            $grid->column('min', '最小值')->display(function () {
                return '<span class="text-success h1 text-bold account-min" data-id="' . $this->id . '">' . number_format($this->low, 4) . '</span>';
            });
            $grid->column('diff', '差值')->display(function () {
                return '<span class="text-success h1 text-bold account-diff" data-id="' . $this->id . '">' . number_format($this->value, 4) . '</span>';
            });
            $grid->column('high', '高点')->display(function () {
                return '<span class="text-success h1 text-bold account-high" data-id="' . $this->id . '">' . number_format($this->high, 4) . '</span>';
            });
            $grid->column('low', '低点')->display(function () {
                return '<span class="text-success h1 text-bold account-low" data-id="' . $this->id . '">' . number_format($this->low, 4) . '</span>';
            });
            $grid->column('up-sum', '涨总和')->display(function () {
                // 实时计算关联的所有history记录的diff总和
                $upTotalDiff = $this->up_total_diff;
                return '<span class="text-info h2 text-bold account-up-sum" data-id="' . $this->id . '">' . number_format($upTotalDiff, 4) . '</span>';
            });
            $grid->column('down-sum', '跌总和')->display(function () {
                // 实时计算关联的所有history记录的diff总和
                $downTotalDiff = $this->down_total_diff;
                return '<span class="text-info h2 text-bold account-down-sum" data-id="' . $this->id . '">' . number_format($downTotalDiff, 4) . '</span>';
            });
            $grid->column('sum', '历史总和')->display(function () {
                // 实时计算关联的所有history记录的diff总和
                $totalDiff = $this->total_diff;
                return '<span class="text-info h2 text-bold account-sum" data-id="' . $this->id . '">' . number_format($totalDiff, 4) . '</span>';
            });
            $grid->column('pid');
//            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($this->state == AccountModel::STATE_START) {
                    $actions->append('<a class="btn btn-sm btn-danger" href="'
                        . admin_route('accounts.toggle_state', [$this->getKey()]) . '">停止</a>');
                } else if ($this->state == AccountModel::STATE_END) {
                    $actions->append('<a class="btn btn-sm btn-success" href="'
                        . admin_route('accounts.toggle_state', [$this->getKey()]) . '">执行</a>');
                }

                if ($this->trend == AccountModel::TREND_UP) {
                    $actions->append(' <a class="btn btn-sm btn-danger" href="'
                        . admin_route('accounts.toggle_trend', [$this->getKey()]) . '">下跌</a>');
                } else if ($this->trend == AccountModel::TREND_DOWN) {
                    $actions->append(' <a class="btn btn-sm btn-success" href="'
                        . admin_route('accounts.toggle_trend', [$this->getKey()]) . '">上涨</a>');
                }

                if ($this->trade == AccountModel::STATE_START) {
                    $actions->append(' <a class="btn btn-sm btn-danger" href="'
                        . admin_route('accounts.toggle_trade', [$this->getKey()]) . '">卖出</a>');
                } else if ($this->trade == AccountModel::STATE_END) {
                    $actions->append(' <a class="btn btn-sm btn-success" href="'
                        . admin_route('accounts.toggle_trade', [$this->getKey()]) . '">买入</a>');
                }

                $actions->append(' <a class="btn btn-sm btn-info" href="'
                    . admin_route('accounts.show', [$this->id]) . '">交易</a>');
                $actions->append(' <a class="btn btn-sm btn-success" href="'
                    . admin_route('histories.index') . '?account_id=' . $this->id . '">历史</a>');
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
            });

            $grid->tools(new ChangeUpTrend());
            $grid->tools(new ChangeDownTrend());

            $grid->disableBatchActions();
            $grid->paginate(40);

            // 异步刷新数据
            Admin::script(
                <<<JS
                // 清除之前的定时器（如果存在）
                if (window.accountUpdateTimer) {
                    clearInterval(window.accountUpdateTimer);
                    window.accountUpdateTimer = null;
                }

                function updateAccountData() {
                    $.ajax({
                        url: '{$grid->resource()}/get-data',
                        method: 'GET',
                        success: function(response) {
                            if (response.status && response.data) {
                                response.data.forEach(function(account) {
                                    // 更新当前值
                                    $('.account-value[data-id="' + account.id + '"]').text(
                                        parseFloat(account.value).toFixed(4)
                                    );
                                    $('.account-max[data-id="' + account.id + '"]').text(
                                        parseFloat(account.max).toFixed(4)
                                    );
                                    $('.account-min[data-id="' + account.id + '"]').text(
                                        parseFloat(account.min).toFixed(4)
                                    );
                                    $('.account-diff[data-id="' + account.id + '"]').text(
                                        parseFloat(account.diff).toFixed(4)
                                    );
                                    $('.account-high[data-id="' + account.id + '"]').text(
                                        parseFloat(account.high).toFixed(4)
                                    );
                                    $('.account-low[data-id="' + account.id + '"]').text(
                                        parseFloat(account.low).toFixed(4)
                                    );
                                    $('.trend[data-id="' + account.id + '"]').text(
                                        account.trend
                                    );
                                    $('.record-trend[data-id="' + account.id + '"]').text(
                                        account.record_trend
                                    );
                                });
                            }
                        }
                    });
                }

                // 每秒异步更新一次数据，并保存定时器ID
                window.accountUpdateTimer = setInterval(updateAccountData, 600);

                // 监听pjax发送请求事件，在离开页面前清除定时器
                $(document).one('pjax:send', function() {
                    if (window.accountUpdateTimer) {
                        clearInterval(window.accountUpdateTimer);
                        window.accountUpdateTimer = null;
                    }
                });
JS
            );
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
        return Show::make($id, new AccountModel(), function (Show $show) {
            $show->field('id');
            $show->field('appid');
            $show->field('secret');
            $show->field('state');
            $show->field('trend');
            $show->field('sum');
            $show->field('value');
            $show->field('total_diff');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    public function show($id, Content $content)
    {
        return redirect(admin_route('histories.index') . '?account_id=' . $id . '&history=true');
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Account(), function (Form $form) {
            $form->display('id');
            $form->text('appid');
            $form->text('secret');
            $form->text('passphrase');
//            $form->text('trend');
//            $form->text('sum');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function toggleState($id)
    {
        $account = AccountModel::find($id);

        if ($account->state == AccountModel::STATE_START) {
            // 当前是开始状态，点击结束
            if (!$account->value || $account->trade == AccountModel::STATE_END) {
                $this->stopCProgram($account);
                $account->state = AccountModel::STATE_END;

                $account->value = 0;
                $account->high = 0;
                $account->low = 0;
            } else {
                admin_toastr("有进行中的交易, 不能停止");
            }
        } else {
            // 当前是结束状态，点击开始
            $this->startCProgram($account);
            $account->state = AccountModel::STATE_START;
        }

        $account->save();
        return redirect()->route("dcat.admin.accounts.index");
    }

    /**
     * 启动C程序
     *
     * @param AccountModel $account
     */
    private function startCProgram(AccountModel $account)
    {
        // C程序的路径
        $cProgramPath = public_path('bitget_all_trend');
        if ($account->id === 11) { // 1
            $cProgramPath = public_path('bitget');
        } else if ($account->id === 21) { // 2
            $cProgramPath = public_path('bitget_-20');
        } else if ($account->id === 111) { // 3
            $cProgramPath = public_path('bitget_p');
        } else if ($account->id === 222) { // 4
            $cProgramPath = public_path('bitget_-30');
        } else if ($account->id === 333) { // 5
            $cProgramPath = public_path('bitget_p_30');
        } else if ($account->id === 444) { // 6
            $cProgramPath = public_path('bitget_20_-8');
        } else if ($account->id === 555) { // 7
            $cProgramPath = public_path('bitget_20_-3');
        } else if ($account->id === 588) { // 8
            $cProgramPath = public_path('bitget_p_-40');
        } else if ($account->id === 630) { // 21
            $cProgramPath = public_path('bitget-big');
        } else if ($account->id === 666) { // 22
            $cProgramPath = public_path('bitget-big_-20');
        } else if ($account->id === 777) { // 23
            $cProgramPath = public_path('bitget-big-p');
        } else if ($account->id === 888) { // 24
            $cProgramPath = public_path('bitget-big_-30');
        } else if ($account->id === 999) { // 25
            $cProgramPath = public_path('bitget-big-p-30');
        } else if ($account->id === 1111) { // 26
            $cProgramPath = public_path('bitget-big_20_-8');
        } else if ($account->id === 1222) { // 27
            $cProgramPath = public_path('bitget-big_20_-3');
        } else if ($account->id === 1333) { // 28
            $cProgramPath = public_path('bitget-big_p_-40');
        } else if ($account->id === 1400) { // 31
            $cProgramPath = public_path('bitget-s600-s100-all');
        } else if ($account->id === 1411) { // 31
            $cProgramPath = public_path('bitget-s600-s600-all');
        } else if ($account->id === 1444) { // 31
            $cProgramPath = public_path('bitget-s600-s100');
        } else if ($account->id === 1555) { // 32
            $cProgramPath = public_path('bitget-s600-s600');
        } else if ($account->id === 1666) { // 33
            $cProgramPath = public_path('bitget-s600_20_-8');
        } else if ($account->id === 1777) { // 34
            $cProgramPath = public_path('bitget-s600_-8_40_20');
        } else if ($account->id === 1888) { // 41
            $cProgramPath = public_path('bitget-small_-4_20_all');
        } else if ($account->id === 1999) { // 42
            $cProgramPath = public_path('bitget-small_20_all');
        } else if ($account->id === 2000) { // 41
            $cProgramPath = public_path('bitget-small_-4_20');
        } else if ($account->id === 2111) { // 42
            $cProgramPath = public_path('bitget-small_20');
        } else if ($account->id === 2222) { // 43
            $cProgramPath = public_path('bitget-small_up_-4_20_all');
        } else if ($account->id === 2333) { // 44
            $cProgramPath = public_path('bitget-small_up_20_all');
        } else if ($account->id === 2444) { // 43
            $cProgramPath = public_path('bitget-small_up_-4_20');
        } else if ($account->id === 2555) { // 44
            $cProgramPath = public_path('bitget-small_up_20');
        }

        // 检查文件是否存在
        if (!file_exists($cProgramPath)) {
            throw new \Exception("程序文件不存在: {$cProgramPath}");
        }

        // Linux/Unix 系统使用 nohup 启动后台进程
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            // 使用 bash -c 执行命令，获取实际进程 PID
            $appid = escapeshellarg($account->appid);
            $secret = escapeshellarg($account->secret);
            $trend = escapeshellarg($account->trend);
            $passphrase = escapeshellarg($account->passphrase);
            $logPath = public_path('logs/bitget-' . $account->id . '.log');

            // 使用 nohup 在后台启动，并重定向输出
            $command = "nohup \"{$cProgramPath}\" --id {$appid} --secret {$secret} --trend {$trend} --passphrase {$passphrase} --uid {$account->id} > \"{$logPath}\" 2>&1 & echo $!";

            // 执行命令并获取 PID
            $pid = shell_exec($command);
            $pid = trim($pid);

            if ($pid && is_numeric($pid)) {
                $account->pid = (int)$pid;
            } else {
                throw new \Exception("无法获取进程 PID");
            }
        } else {
            // Windows 系统
            $appid = escapeshellarg($account->appid);
            $secret = escapeshellarg($account->secret);

            $descriptorspec = [
                0 => ["pipe", "r"],
                1 => ["pipe", "w"],
                2 => ["pipe", "w"]
            ];

            $process = proc_open(
                "\"$cProgramPath\" --id $appid --secret $secret",
                $descriptorspec,
                $pipes,
                public_path(),
                null,
                ['bypass_shell' => true]
            );

            if (is_resource($process)) {
                $status = proc_get_status($process);
                $account->pid = $status['pid'];

                foreach ($pipes as $pipe) {
                    fclose($pipe);
                }

                proc_close($process);
            } else {
                throw new \Exception("无法启动程序");
            }
        }
    }

    /**
     * 停止C程序
     *
     * @param AccountModel $account
     */
    private function stopCProgram(AccountModel $account)
    {
        if ($account->pid) {
            // 在Windows下终止进程
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // 使用taskkill命令终止进程及其子进程
                exec("taskkill /F /T /PID {$account->pid} 2>&1", $output, $returnCode);
            } else {
                // Linux/Unix下使用pkill杀死进程组，或者先杀子进程再杀父进程
                // 方法1: 杀死进程及其子进程
                exec("pkill -P {$account->pid} 2>&1", $output, $returnCode);
                exec("kill -9 {$account->pid} 2>&1", $output, $returnCode);

                // 方法2: 或者直接杀死进程名（如果进程名唯一）
                // exec("pkill -9 -f bitget 2>&1", $output, $returnCode);
            }

            // 清除进程ID
            $account->pid = null;
        }
    }

    public function toggleTrend($id)
    {
        $account = AccountModel::find($id);
        $account->trend = $account->trend == AccountModel::TREND_UP ? AccountModel::TREND_DOWN : AccountModel::TREND_UP;
        $account->save();

        // 更新配置文件，供C程序读取
        $this->updateConfigFile($account);

        // 记录日志，方便调试
        \Log::info("账户 {$id} 趋势已切换为: {$account->trend}，配置文件已更新");

        return redirect()->route("dcat.admin.accounts.index");
    }

    public function toggleTrade($id)
    {
        $account = AccountModel::find($id);
        $account->trade = $account->trade == AccountModel::STATE_START ? AccountModel::STATE_END : AccountModel::STATE_START;
        $account->save();

        // 更新配置文件，供C程序读取
        $this->updateConfigFile($account);

        // 记录日志，方便调试
        \Log::info("账户 {$id} 交易已切换为: {$account->trade}，配置文件已更新");
        return redirect()->route("dcat.admin.accounts.index");
    }

    /**
     * 更新配置文件
     *
     * @param AccountModel $account
     */
    public function updateConfigFile(AccountModel $account)
    {
        $configPath = public_path('config_' . $account->id . '.json');

        // 读取现有配置
        if (file_exists($configPath)) {
            $config = json_decode(file_get_contents($configPath), true);
        } else {
            $config = [];
        }

        // 更新趋势值
        $config['trend'] = $account->trend;
        $config['trade'] = $account->trade;
        $config['uid'] = (string)$account->id;

        // 使用临时文件+原子重命名，避免读取到不完整的文件
        $tempPath = $configPath . '.tmp';
        file_put_contents($tempPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        rename($tempPath, $configPath);
    }

    /**
     * 获取账户数据用于异步更新
     */
    public function getData()
    {
        $accounts = AccountModel::all();

        // 如果没有账户，直接返回空数据
        if ($accounts->isEmpty()) {
            return response()->json([
                'status' => true,
                'data' => [],
            ]);
        }

        // 批量获取每个账户的最新历史记录ID
        $accountIds = $accounts->pluck('id')->toArray();

        // 使用子查询获取每个账户的最新历史记录
        $latestHistoryIds = DB::table('history')
            ->select('account_id', DB::raw('MAX(id) as max_id'))
            ->whereIn('account_id', $accountIds)
            ->groupBy('account_id')
            ->pluck('max_id');

        // 批量加载这些历史记录
        $histories = History::whereIn('id', $latestHistoryIds)
            ->get()
            ->keyBy('account_id');

        $data = $accounts->map(function ($account) use ($histories) {
            $history = $histories->get($account->id);
            $hasActiveHistory = $history && $history->trade && !$history->end_value;

            return [
                'id' => $account->id,
                'value' => $account->value,
                'max' => $account->high,
                'min' => $account->low,
                'diff' => $hasActiveHistory ? $account->value : 0,
                'high' => $hasActiveHistory ? $account->high : 0,
                'low' => $hasActiveHistory ? $account->low : 0,
                'trend' => $account->trend,
                'record_trend' => $account->record_trend,
//                'total_diff' => $account->total_diff,
//                'up_total_diff' => $account->up_total_diff,
//                'down_total_diff' => $account->down_total_diff,
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function updateValue()
    {
        $request = request();
        $history_id = $request->input('history_id');
        $diff = $request->input('price');

        // 先获取 account_id
        $history = DB::table('history')
            ->where('id', $history_id)
            ->whereNull('ended_at')
            ->value('account_id');

        if (!$history) {
            return response()->json([
                'status' => false,
                'message' => '记录不存在',
            ], 404);
        }

        // 使用一条 SQL 完成所有更新逻辑，利用数据库的 CASE WHEN
        DB::table('account')
            ->where('id', $history)
            ->where('value', '!=', $diff) // 只有值不同时才更新
            ->update([
                'value' => $diff,
                'high' => DB::raw("CASE WHEN {$diff} > high THEN {$diff} ELSE high END"),
                'low' => DB::raw("CASE WHEN {$diff} < low THEN {$diff} ELSE low END"),
            ]);

        return response()->json([
            'status' => true,
            'message' => '更新成功',
        ]);
    }
}
