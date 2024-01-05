## 注意事项
- 更换小程序后, 需要手动在数据库重置 weapp_openid, 因为没有 UnionId

- 需要再 nginx.conf 里添加 client_max_body_size 100M; 重启 nginx

- 需要修改 
  - CodeToSession@weappCodeToSession
  - 小程序项目 wepy.config.js 的 PROGRAM
