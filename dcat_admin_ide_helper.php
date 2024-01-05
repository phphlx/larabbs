<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection post_count
     * @property Grid\Column|Collection link
     * @property Grid\Column|Collection share_title
     * @property Grid\Column|Collection share_img
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection model_type
     * @property Grid\Column|Collection model_id
     * @property Grid\Column|Collection notifiable_type
     * @property Grid\Column|Collection notifiable_id
     * @property Grid\Column|Collection data
     * @property Grid\Column|Collection read_at
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection guard_name
     * @property Grid\Column|Collection day
     * @property Grid\Column|Collection intro
     * @property Grid\Column|Collection qrcode
     * @property Grid\Column|Collection num
     * @property Grid\Column|Collection btn_text
     * @property Grid\Column|Collection from
     * @property Grid\Column|Collection share_desc
     * @property Grid\Column|Collection admin_id
     * @property Grid\Column|Collection money
     * @property Grid\Column|Collection salesperson_id
     * @property Grid\Column|Collection topic_id
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection body
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection reply_count
     * @property Grid\Column|Collection view_count
     * @property Grid\Column|Collection last_reply_user_id
     * @property Grid\Column|Collection excerpt
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection weixin_openid
     * @property Grid\Column|Collection weapp_openid
     * @property Grid\Column|Collection weixin_session_key
     * @property Grid\Column|Collection weixin_unionid
     * @property Grid\Column|Collection tiktok_openid
     * @property Grid\Column|Collection tiktok_unionid
     * @property Grid\Column|Collection tiktok_session_key
     * @property Grid\Column|Collection kuaishou_openid
     * @property Grid\Column|Collection kuaishou_session_key
     * @property Grid\Column|Collection start_at
     * @property Grid\Column|Collection end_at
     * @property Grid\Column|Collection introduction
     * @property Grid\Column|Collection notification_count
     * @property Grid\Column|Collection last_actived_at
     * @property Grid\Column|Collection registration_id
     * @property Grid\Column|Collection video
     * @property Grid\Column|Collection time
     * @property Grid\Column|Collection ad_title
     * @property Grid\Column|Collection ad_content
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection post_count(string $label = null)
     * @method Grid\Column|Collection link(string $label = null)
     * @method Grid\Column|Collection share_title(string $label = null)
     * @method Grid\Column|Collection share_img(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection model_type(string $label = null)
     * @method Grid\Column|Collection model_id(string $label = null)
     * @method Grid\Column|Collection notifiable_type(string $label = null)
     * @method Grid\Column|Collection notifiable_id(string $label = null)
     * @method Grid\Column|Collection data(string $label = null)
     * @method Grid\Column|Collection read_at(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection guard_name(string $label = null)
     * @method Grid\Column|Collection day(string $label = null)
     * @method Grid\Column|Collection intro(string $label = null)
     * @method Grid\Column|Collection qrcode(string $label = null)
     * @method Grid\Column|Collection num(string $label = null)
     * @method Grid\Column|Collection btn_text(string $label = null)
     * @method Grid\Column|Collection from(string $label = null)
     * @method Grid\Column|Collection share_desc(string $label = null)
     * @method Grid\Column|Collection admin_id(string $label = null)
     * @method Grid\Column|Collection money(string $label = null)
     * @method Grid\Column|Collection salesperson_id(string $label = null)
     * @method Grid\Column|Collection topic_id(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection body(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection reply_count(string $label = null)
     * @method Grid\Column|Collection view_count(string $label = null)
     * @method Grid\Column|Collection last_reply_user_id(string $label = null)
     * @method Grid\Column|Collection excerpt(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection weixin_openid(string $label = null)
     * @method Grid\Column|Collection weapp_openid(string $label = null)
     * @method Grid\Column|Collection weixin_session_key(string $label = null)
     * @method Grid\Column|Collection weixin_unionid(string $label = null)
     * @method Grid\Column|Collection tiktok_openid(string $label = null)
     * @method Grid\Column|Collection tiktok_unionid(string $label = null)
     * @method Grid\Column|Collection tiktok_session_key(string $label = null)
     * @method Grid\Column|Collection kuaishou_openid(string $label = null)
     * @method Grid\Column|Collection kuaishou_session_key(string $label = null)
     * @method Grid\Column|Collection start_at(string $label = null)
     * @method Grid\Column|Collection end_at(string $label = null)
     * @method Grid\Column|Collection introduction(string $label = null)
     * @method Grid\Column|Collection notification_count(string $label = null)
     * @method Grid\Column|Collection last_actived_at(string $label = null)
     * @method Grid\Column|Collection registration_id(string $label = null)
     * @method Grid\Column|Collection video(string $label = null)
     * @method Grid\Column|Collection time(string $label = null)
     * @method Grid\Column|Collection ad_title(string $label = null)
     * @method Grid\Column|Collection ad_content(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection content
     * @property Show\Field|Collection post_count
     * @property Show\Field|Collection link
     * @property Show\Field|Collection share_title
     * @property Show\Field|Collection share_img
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection path
     * @property Show\Field|Collection model_type
     * @property Show\Field|Collection model_id
     * @property Show\Field|Collection notifiable_type
     * @property Show\Field|Collection notifiable_id
     * @property Show\Field|Collection data
     * @property Show\Field|Collection read_at
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection guard_name
     * @property Show\Field|Collection day
     * @property Show\Field|Collection intro
     * @property Show\Field|Collection qrcode
     * @property Show\Field|Collection num
     * @property Show\Field|Collection btn_text
     * @property Show\Field|Collection from
     * @property Show\Field|Collection share_desc
     * @property Show\Field|Collection admin_id
     * @property Show\Field|Collection money
     * @property Show\Field|Collection salesperson_id
     * @property Show\Field|Collection topic_id
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection body
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection reply_count
     * @property Show\Field|Collection view_count
     * @property Show\Field|Collection last_reply_user_id
     * @property Show\Field|Collection excerpt
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection weixin_openid
     * @property Show\Field|Collection weapp_openid
     * @property Show\Field|Collection weixin_session_key
     * @property Show\Field|Collection weixin_unionid
     * @property Show\Field|Collection tiktok_openid
     * @property Show\Field|Collection tiktok_unionid
     * @property Show\Field|Collection tiktok_session_key
     * @property Show\Field|Collection kuaishou_openid
     * @property Show\Field|Collection kuaishou_session_key
     * @property Show\Field|Collection start_at
     * @property Show\Field|Collection end_at
     * @property Show\Field|Collection introduction
     * @property Show\Field|Collection notification_count
     * @property Show\Field|Collection last_actived_at
     * @property Show\Field|Collection registration_id
     * @property Show\Field|Collection video
     * @property Show\Field|Collection time
     * @property Show\Field|Collection ad_title
     * @property Show\Field|Collection ad_content
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection post_count(string $label = null)
     * @method Show\Field|Collection link(string $label = null)
     * @method Show\Field|Collection share_title(string $label = null)
     * @method Show\Field|Collection share_img(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection model_type(string $label = null)
     * @method Show\Field|Collection model_id(string $label = null)
     * @method Show\Field|Collection notifiable_type(string $label = null)
     * @method Show\Field|Collection notifiable_id(string $label = null)
     * @method Show\Field|Collection data(string $label = null)
     * @method Show\Field|Collection read_at(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection guard_name(string $label = null)
     * @method Show\Field|Collection day(string $label = null)
     * @method Show\Field|Collection intro(string $label = null)
     * @method Show\Field|Collection qrcode(string $label = null)
     * @method Show\Field|Collection num(string $label = null)
     * @method Show\Field|Collection btn_text(string $label = null)
     * @method Show\Field|Collection from(string $label = null)
     * @method Show\Field|Collection share_desc(string $label = null)
     * @method Show\Field|Collection admin_id(string $label = null)
     * @method Show\Field|Collection money(string $label = null)
     * @method Show\Field|Collection salesperson_id(string $label = null)
     * @method Show\Field|Collection topic_id(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection body(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection reply_count(string $label = null)
     * @method Show\Field|Collection view_count(string $label = null)
     * @method Show\Field|Collection last_reply_user_id(string $label = null)
     * @method Show\Field|Collection excerpt(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection weixin_openid(string $label = null)
     * @method Show\Field|Collection weapp_openid(string $label = null)
     * @method Show\Field|Collection weixin_session_key(string $label = null)
     * @method Show\Field|Collection weixin_unionid(string $label = null)
     * @method Show\Field|Collection tiktok_openid(string $label = null)
     * @method Show\Field|Collection tiktok_unionid(string $label = null)
     * @method Show\Field|Collection tiktok_session_key(string $label = null)
     * @method Show\Field|Collection kuaishou_openid(string $label = null)
     * @method Show\Field|Collection kuaishou_session_key(string $label = null)
     * @method Show\Field|Collection start_at(string $label = null)
     * @method Show\Field|Collection end_at(string $label = null)
     * @method Show\Field|Collection introduction(string $label = null)
     * @method Show\Field|Collection notification_count(string $label = null)
     * @method Show\Field|Collection last_actived_at(string $label = null)
     * @method Show\Field|Collection registration_id(string $label = null)
     * @method Show\Field|Collection video(string $label = null)
     * @method Show\Field|Collection time(string $label = null)
     * @method Show\Field|Collection ad_title(string $label = null)
     * @method Show\Field|Collection ad_content(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
