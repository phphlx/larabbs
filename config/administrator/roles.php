<?php

use Spatie\Permission\Models\Role;

return [
    'title'   => '角色',
    'single'  => '角色',
    'model'   => Role::class,

    'permission'=> function()
    {
        return Auth::user()->can('manage_users');
    },

    // 对 CRUD 动作的单独权限控制，通过返回布尔值来控制权限。
    'action_permissions' => [
        // 控制『新建按钮』的显示
        'create' => function ($model) {
            return true;
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
        // 允许查看
        'view' => function ($model) {
            return true;
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '标识'
        ],
        'permissions' => [
            'title'  => '权限(仅当前角色无用户时可修改/删除',
            'output' => function ($value, $model) {
                $model->load('permissions');
                $result = [];
                foreach ($model->permissions as $permission) {
                    $result[] = $permission->name;
                }

                return empty($result) ? 'N/A' : implode(' | ', $result);
            },
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'output' => function ($value, $model) {
                return $value;
            },
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'name' => [
            'title' => '标识',
        ],
        'permissions' => [
            'type' => 'relationship',
            'title' => '权限',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '标识',
        ]
    ],

    // 新建和编辑时的表单验证规则
    'rules' => [
        'name' => 'required|max:15|unique:roles,name',
    ],

    // 表单验证错误时定制错误消息
    'messages' => [
        'name.required' => '标识不能为空',
        'name.unique' => '标识已存在',
    ]
];
