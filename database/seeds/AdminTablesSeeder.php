<?php

namespace Database\Seeds;

use Dcat\Admin\Models;
use Illuminate\Database\Seeder;
use DB;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        Models\Menu::truncate();
        Models\Menu::insert(
            [
                [
                    "id" => 2,
                    "parent_id" => 0,
                    "order" => 9,
                    "title" => "Admin",
                    "icon" => "feather icon-settings",
                    "uri" => "",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => "2024-01-05 10:33:01"
                ],
                [
                    "id" => 3,
                    "parent_id" => 2,
                    "order" => 10,
                    "title" => "Users",
                    "icon" => "",
                    "uri" => "auth/users",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => "2024-01-05 10:33:01"
                ],
                [
                    "id" => 4,
                    "parent_id" => 2,
                    "order" => 11,
                    "title" => "Roles",
                    "icon" => "",
                    "uri" => "auth/roles",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => "2024-01-05 10:33:01"
                ],
                [
                    "id" => 5,
                    "parent_id" => 2,
                    "order" => 12,
                    "title" => "Permission",
                    "icon" => "",
                    "uri" => "auth/permissions",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => "2024-01-05 10:33:01"
                ],
                [
                    "id" => 6,
                    "parent_id" => 2,
                    "order" => 13,
                    "title" => "Menu",
                    "icon" => "",
                    "uri" => "auth/menu",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => "2024-01-05 10:33:01"
                ],
                [
                    "id" => 7,
                    "parent_id" => 2,
                    "order" => 14,
                    "title" => "Extensions",
                    "icon" => "",
                    "uri" => "auth/extensions",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => "2024-01-05 10:33:01"
                ],
                [
                    "id" => 8,
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "用户",
                    "icon" => "fa-users",
                    "uri" => "/users",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-27 10:28:26",
                    "updated_at" => "2024-01-03 16:32:28"
                ],
                [
                    "id" => 10,
                    "parent_id" => 0,
                    "order" => 3,
                    "title" => "用户权限",
                    "icon" => "fa-lock",
                    "uri" => "/permissions",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-27 11:08:58",
                    "updated_at" => "2024-01-03 16:32:28"
                ],
                [
                    "id" => 11,
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "开通记录",
                    "icon" => "fa-apple",
                    "uri" => "/records",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-27 11:35:38",
                    "updated_at" => "2024-01-03 16:32:28"
                ],
                [
                    "id" => 13,
                    "parent_id" => 0,
                    "order" => 4,
                    "title" => "销售员",
                    "icon" => "fa-venus-mars",
                    "uri" => "/salespeople",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-27 12:10:09",
                    "updated_at" => "2024-01-03 16:32:28"
                ],
                [
                    "id" => 14,
                    "parent_id" => 0,
                    "order" => 5,
                    "title" => "群记录",
                    "icon" => "fa-wechat",
                    "uri" => "/quns",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-27 12:13:30",
                    "updated_at" => "2024-01-03 16:32:28"
                ],
                [
                    "id" => 15,
                    "parent_id" => 0,
                    "order" => 6,
                    "title" => "视频记录",
                    "icon" => "fa-video-camera",
                    "uri" => "/videos",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2022-09-27 12:13:56",
                    "updated_at" => "2024-01-03 16:32:28"
                ],
                [
                    "id" => 16,
                    "parent_id" => 0,
                    "order" => 8,
                    "title" => "配置",
                    "icon" => "fa-cog",
                    "uri" => "/configs",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2024-01-03 16:32:08",
                    "updated_at" => "2024-01-05 10:33:06"
                ],
                [
                    "id" => 17,
                    "parent_id" => 0,
                    "order" => 7,
                    "title" => "公告",
                    "icon" => "fa-bell-o",
                    "uri" => "/articles",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2024-01-05 10:32:41",
                    "updated_at" => "2024-01-05 10:33:21"
                ]
            ]
        );

        Models\Permission::truncate();
        Models\Permission::insert(
            [
                [
                    "id" => 1,
                    "name" => "Auth management",
                    "slug" => "auth-management",
                    "http_method" => "",
                    "http_path" => "",
                    "order" => 1,
                    "parent_id" => 0,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => NULL
                ],
                [
                    "id" => 2,
                    "name" => "Users",
                    "slug" => "users",
                    "http_method" => "",
                    "http_path" => "/auth/users*",
                    "order" => 2,
                    "parent_id" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => NULL
                ],
                [
                    "id" => 3,
                    "name" => "Roles",
                    "slug" => "roles",
                    "http_method" => "",
                    "http_path" => "/auth/roles*",
                    "order" => 3,
                    "parent_id" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => NULL
                ],
                [
                    "id" => 4,
                    "name" => "Permissions",
                    "slug" => "permissions",
                    "http_method" => "",
                    "http_path" => "/auth/permissions*",
                    "order" => 4,
                    "parent_id" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => NULL
                ],
                [
                    "id" => 5,
                    "name" => "Menu",
                    "slug" => "menu",
                    "http_method" => "",
                    "http_path" => "/auth/menu*",
                    "order" => 5,
                    "parent_id" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => NULL
                ],
                [
                    "id" => 6,
                    "name" => "Extension",
                    "slug" => "extension",
                    "http_method" => "",
                    "http_path" => "/auth/extensions*",
                    "order" => 6,
                    "parent_id" => 1,
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => NULL
                ],
                [
                    "id" => 7,
                    "name" => "用户",
                    "slug" => "simple-user",
                    "http_method" => "",
                    "http_path" => "/users*",
                    "order" => 7,
                    "parent_id" => 0,
                    "created_at" => "2022-09-27 11:23:02",
                    "updated_at" => "2022-10-06 18:57:10"
                ],
                [
                    "id" => 8,
                    "name" => "开通记录",
                    "slug" => "record",
                    "http_method" => "",
                    "http_path" => "/records*",
                    "order" => 8,
                    "parent_id" => 0,
                    "created_at" => "2022-10-06 18:56:21",
                    "updated_at" => "2022-10-06 18:56:21"
                ],
                [
                    "id" => 9,
                    "name" => "销售员",
                    "slug" => "salespeople",
                    "http_method" => "",
                    "http_path" => "/salespeople*",
                    "order" => 10,
                    "parent_id" => 0,
                    "created_at" => "2022-10-06 18:57:46",
                    "updated_at" => "2022-10-06 19:51:29"
                ],
                [
                    "id" => 10,
                    "name" => "群记录",
                    "slug" => "qun",
                    "http_method" => "",
                    "http_path" => "/quns*",
                    "order" => 11,
                    "parent_id" => 0,
                    "created_at" => "2022-10-06 19:00:20",
                    "updated_at" => "2022-10-06 19:51:29"
                ],
                [
                    "id" => 11,
                    "name" => "视频记录",
                    "slug" => "video",
                    "http_method" => "",
                    "http_path" => "/videos*",
                    "order" => 12,
                    "parent_id" => 0,
                    "created_at" => "2022-10-06 19:00:45",
                    "updated_at" => "2022-10-06 19:51:29"
                ],
                [
                    "id" => 12,
                    "name" => "用户权限",
                    "slug" => "user-permissions",
                    "http_method" => "",
                    "http_path" => "/permissions*",
                    "order" => 9,
                    "parent_id" => 0,
                    "created_at" => "2022-10-06 19:06:49",
                    "updated_at" => "2022-10-06 19:51:29"
                ]
            ]
        );

        Models\Role::truncate();
        Models\Role::insert(
            [
                [
                    "id" => 1,
                    "name" => "Administrator",
                    "slug" => "administrator",
                    "created_at" => "2022-09-26 17:44:07",
                    "updated_at" => "2022-09-26 17:44:07"
                ],
                [
                    "id" => 2,
                    "name" => "founder",
                    "slug" => "founder",
                    "created_at" => "2022-09-27 11:17:02",
                    "updated_at" => "2022-09-27 11:17:02"
                ]
            ]
        );

        Models\Setting::truncate();
		Models\Setting::insert(
			[

            ]
		);

		Models\Extension::truncate();
		Models\Extension::insert(
			[

            ]
		);

		Models\ExtensionHistory::truncate();
		Models\ExtensionHistory::insert(
			[

            ]
		);

        // pivot tables
        DB::table('admin_permission_menu')->truncate();
		DB::table('admin_permission_menu')->insert(
			[
                [
                    "permission_id" => 7,
                    "menu_id" => 8,
                    "created_at" => "2022-09-27 11:23:02",
                    "updated_at" => "2022-09-27 11:23:02"
                ],
                [
                    "permission_id" => 8,
                    "menu_id" => 11,
                    "created_at" => "2022-10-06 18:56:21",
                    "updated_at" => "2022-10-06 18:56:21"
                ],
                [
                    "permission_id" => 9,
                    "menu_id" => 13,
                    "created_at" => "2022-10-06 18:57:46",
                    "updated_at" => "2022-10-06 18:57:46"
                ],
                [
                    "permission_id" => 10,
                    "menu_id" => 14,
                    "created_at" => "2022-10-06 19:01:05",
                    "updated_at" => "2022-10-06 19:01:05"
                ],
                [
                    "permission_id" => 11,
                    "menu_id" => 15,
                    "created_at" => "2022-10-06 19:00:57",
                    "updated_at" => "2022-10-06 19:00:57"
                ],
                [
                    "permission_id" => 12,
                    "menu_id" => 10,
                    "created_at" => "2022-10-06 19:06:49",
                    "updated_at" => "2022-10-06 19:06:49"
                ]
            ]
		);

        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 3,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 4,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 5,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 6,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 7,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 8,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 10,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 11,
                    "created_at" => "2022-09-27 11:35:38",
                    "updated_at" => "2022-09-27 11:35:38"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 13,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 14,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 15,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 16,
                    "created_at" => "2024-01-03 16:32:08",
                    "updated_at" => "2024-01-03 16:32:08"
                ],
                [
                    "role_id" => 2,
                    "menu_id" => 8,
                    "created_at" => "2022-10-06 18:52:16",
                    "updated_at" => "2022-10-06 18:52:16"
                ],
                [
                    "role_id" => 2,
                    "menu_id" => 13,
                    "created_at" => "2022-10-06 19:05:53",
                    "updated_at" => "2022-10-06 19:05:53"
                ],
                [
                    "role_id" => 2,
                    "menu_id" => 14,
                    "created_at" => "2022-10-06 19:05:53",
                    "updated_at" => "2022-10-06 19:05:53"
                ],
                [
                    "role_id" => 2,
                    "menu_id" => 15,
                    "created_at" => "2022-10-06 19:05:53",
                    "updated_at" => "2022-10-06 19:05:53"
                ]
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 2,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 3,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 4,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 5,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 6,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 7,
                    "created_at" => "2022-10-06 18:51:56",
                    "updated_at" => "2022-10-06 18:51:56"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 8,
                    "created_at" => "2022-10-06 19:07:53",
                    "updated_at" => "2022-10-06 19:07:53"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 9,
                    "created_at" => "2022-10-06 19:07:53",
                    "updated_at" => "2022-10-06 19:07:53"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 10,
                    "created_at" => "2022-10-06 19:07:53",
                    "updated_at" => "2022-10-06 19:07:53"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 11,
                    "created_at" => "2022-10-06 19:07:53",
                    "updated_at" => "2022-10-06 19:07:53"
                ],
                [
                    "role_id" => 1,
                    "permission_id" => 12,
                    "created_at" => "2022-10-06 19:07:53",
                    "updated_at" => "2022-10-06 19:07:53"
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 7,
                    "created_at" => "2022-09-27 11:23:36",
                    "updated_at" => "2022-09-27 11:23:36"
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 9,
                    "created_at" => "2022-10-06 19:05:53",
                    "updated_at" => "2022-10-06 19:05:53"
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 10,
                    "created_at" => "2022-10-06 19:05:53",
                    "updated_at" => "2022-10-06 19:05:53"
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 11,
                    "created_at" => "2022-10-06 19:05:53",
                    "updated_at" => "2022-10-06 19:05:53"
                ]
            ]
        );

        // finish
    }
}
