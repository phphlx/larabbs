<?php

return [
    'title'   => '群记录',
    'single'  => '群记录',
    'model'   => \App\Models\Qun::class,

    // 访问权限判断
    'permission'=> function()
    {
        // 只允许站长管理站点配置
        return Auth::user()->hasRole('Founder');
    },

    // 对 CRUD 动作的单独权限控制，通过返回布尔值来控制权限。
    'action_permissions' => [
        // 控制『新建按钮』的显示
        'create' => function ($model) {
            return false;
        },
        // 更新
        'update' => function ($model) {
            return false;
        },
        // 删除
        'delete' => function ($model) {
            return true;
        },
        // 允许查看
        'view' => function ($model) {
            return true;
        },
    ],

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'user' => [
            'title'    => '用户',
            'sortable' => false,
            'output'   => function ($value, $model) {
                $value = $model->user->email ? : $model->user->phone;
                return model_link($value, $model->user);
            },
        ],
        'name' => [
            'title'    => '群名称',
        ],
        'intro' => [
            'title'    => '引导语',
        ],
        'type' => [
            'title'    => '模式',
            'output'   => function ($value, $model) {
                if ($value == 1) {
                    $value = '模式1, 当前页面显示';
                } elseif ($value == 2) {
                    $value = '模式2, 点击预览';
                }
                return $value;
            },
        ],
        'avatar' => [
            'title'    => '群头像',
            'output'   => function ($value, $model) {
                return "<img src='" . $value ."' alt='' style='max-width: 40px;'>";
            },
        ],
        'qrcode' => [
            'title'    => '二维码',
            'output'   => function ($value, $model) {
                return "<img src='" . $value ."' alt='' style='max-width: 40px;'>";
            },
        ],
        'num' => [
            'title'    => '群人数',
        ],
        'share_title' => [
            'title'    => '分享标题',
        ],
        'share_img' => [
            'title'    => '分享图',
            'output'   => function ($value, $model) {
                return "<img src='" . $value ."' alt='' style='max-width: 40px;'>";
            },
        ],
        'created_at' => [
            'title' => '创建时间',
            'sortable' => true
        ],
        'updated_at' => [
            'title' => '修改时间',
            'sortable' => true,
        ],
    ],
    'edit_fields' => [
        'type' => [
            'title'    => '模式',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '内容 ID',
        ],
        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
    ],
    'rules'   => [
        'title' => 'required'
    ],
    'messages' => [
        'title.required' => '请填写标题',
    ],
];
