~~~
project architecture      黑客马拉松作品 2018-09-02
│
├─0_app                   程序目录
|  ├─Exception            异常处理
│  └─HTTP
|    └─Controllers
|      └─Controller.php   业务处理脚本
│
├─1_bootstrap             iOC 容器
│  ├─app.php              容器注册文件
├─2_bot                   用php+mysql写的简单交互界面 simply interaction web surface 
|  ├─config.php           机器人配置文件
|  ├─Observer.php         微信事件监听
|  ├─Handlers
|    ├─Type
|      ├─TextType.php     微信消息监听脚本
|  ├─run.php              脚本运行入口文件
|  └─vendor               依赖包
├─3_config                配置文件
│  ├─mail                 SMTP 发送邮件脚本
│  └─service.php          邮件 Service Provider
├─4_database              数据库seed, migration 相关
├─5_public                document root
|  ├─index.php            入口文件
├─6_resources             assets 等文件
├─7_routes                路由文件夹
|  ├─web.php              路由文件
├─8_storage               log 文件及编译后的缓存文件
├─9_tests                 测试脚本文件
├─10_vendor               第三方类库
└─readme.md               作品介绍
~~~




