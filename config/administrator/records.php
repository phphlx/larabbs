<?php

use App\Models\Record;

return [
    'title'   => '订单记录',
    'single'  => '订单记录',
    'model'   => Record::class,

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
            if (request('id')) {
                $role = Role::findById(request('id'));
                if (!$role->users()->count()) {
                    return true;
                }
                return false;
            } else {
                return true;
            }
        },
        // 删除
        'delete' => function ($model) {
            return false;
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
        'money' => [
            'title'    => '金额',
            'sortable' => true,
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
        'money' => [
            'title'    => '金额',
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
