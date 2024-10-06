## 注意事项
- 更换小程序后, 需要手动在数据库重置 weapp_openid, 因为没有 UnionId

- 小程序需要修改 
  - 后台, CodeToSession@weappCodeToSession(这个好像不用动)
  - 后台, .env appid appsecret host user database url
  - adminTablesSeeder 需要注释命名空间
  -
  - appid
  - wepy.config.js API_URL
  - 小程序项目 wepy.config.js 的 PROGRAM
  - articles/index.wpy 标题

- 服务器配置
  - 需要修改 nginx.conf 配置 client_max_body_size 100M; 重启 nginx
  - mysql56, php74, phpmyadmin4.4, redis
  - 需要删除 php 配置的 put-env, prop_open 禁用函数, 安装 redis, opcache, exif, fileinfo 扩展
  - 修改php-cli版本, rm -rf /usr/bin/php ln -sf /www/server/php/74/bin/php /usr/bin/php


- weixin配置
    - 清除数据库
    - 修改数据库配置文件
    - 删除 .user.ini 文件
    - 在 qq0330/Application/Adminuser/view/login/创建ver.html, 验证码不显示(真奇怪
    - 修改管理员密码
- lbby配置
    - 修改数据库配置文件
    - 删除 .user.ini 文件
