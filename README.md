## Alipay Cloudrun

小程序云php模版，提供Thinkphp框架快速搭建，实现简易http接口调用、数据库访问、redis缓存、日志打印等功能。


## 云托管部署
#### 1.下载代码
#### 2.快速部署
前往[小程序云托管快速部署](https://opendocs.alipay.com/pre-open/04n0zd),
可选择手工打镜像上传或直接上传代码文件夹部署，服务端口及探活端口填写80
#### 3.服务访问
在部署完成之后，前往云托管平台下的**服务列表**，找到自己的服务并进入，在**服务设置**开启公网域名，之后在浏览器里访问公网域名即进入欢迎页面。
#### 4.数据库连接
用户需要前往云托管平台开通[数据服务](https://opendocs.alipay.com/pre-open/04mphd),
设置账号密码并建库表，表创建可参考
```sql
USE database;
CREATE TABLE IF NOT EXISTS  `record_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `gmt_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `gmt_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `record` varchar(64) NOT NULL COMMENT '记录信息',
  PRIMARY KEY (`id`)
)DEFAULT CHARSET = utf8mb4 COMMENT = '操作信息';
```
建表之后，还需要在环境变量里设置自己的数据库账号、密码、数据库端口、数据库名称，设置步骤：
前往云托管平台下的**服务列表**，找到自己的服务并进入，在**服务设置**里找到**环境变量**并添加如下KV
```text
DATABASE_USERNAME:申请的数据库账号
DATABASE_PASSWORD:账号对应密码
DATABASE_HOST:数据库域名(需带端口，示例127.0.0.1:3306),在数据库服务申请成功时可以拿到
DATABASE_NAME:建立的数据库
```
最后便可以在欢迎页面上的测试数据库访问对该表进行操作。
#### 5.redis缓存
前往云托管平台：首先去开通**缓存服务**，之后在可以在服务设置中设置如下key\value对
```text
REDIS_HOST:redis服务域名，可在开通缓存服务后查到，示例127.0.0.1
REDIS_PORT:redis端口号，可在开通缓存服务后查到，默认6379
REDIS_PASSWORD:缓存服务密码，开通缓存服务时的密码
```
#### 6.查看日志
前往云托管平台：首先在**服务列表**下找到自己的服务并进入，之后在**部署版本**里找到**发布详情**点击进入，找到**实例数量**点击之后会有引导登录实例机器，
登入之后，输入
```powershell
cd /app/runtime/log
```
即可看到相关日志文件。
#### 7.查看监控
前往云托管平台：首先在**服务列表**下找到自己的服务并进入，点击**服务监控**，便可以看到自己服务器的CPU等指标。


## 本地调试
#### 1.下载代码
下载代码至本地。
#### 2.服务访问
运行php think run命令，快速启动，本地访问http://localhost会弹出欢迎页面
#### 3.数据库连接
前往config/database/php，将其中的如下字段设置为自己本地的数据库连接配置
```text
DATABASE_USERNAME:本地数据库账号
DATABASE_PASSWORD:账号对应密码
DATABASE_HOST:数据库域名(需带端口，示例127.0.0.1:3306)
DATABASE_NAME:建立的数据库名
```
示例建表语句(注意database需要替换为自己的数据库)：
```sql
USE database;
CREATE TABLE IF NOT EXISTS  `record_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `gmt_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `gmt_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `record` varchar(64) NOT NULL COMMENT '记录信息',
  PRIMARY KEY (`id`)
)DEFAULT CHARSET = utf8mb4 COMMENT = '操作信息';
```
之后，可在欢迎页面上的测试数据库访问对该表进行操作。
#### 4.redis缓存
前往config/cache.php文件，修改以下参数
```text
REDIS_HOST:redis域名，示例127.0.0.1
REDIS_PORT:redis端口号，默认6379
REDIS_PASSWORD:redis密码，有的话可修改，没有的话可将该字段注释掉
```
即可看到相关日志文件。
#### 5.查看日志
在项目路径下，执行如下命令：
```powershell
cd runtime/log
```
即可看到相关日志文件。
## 目录结构说明

```
.
├── Dockerfile                      Dockerfile文件
├── LICENSE                         LICENSE文件
├── README.md                       README.md文件
├── app                             app目录,包含mvc目录、文件
├── composer.json                   composer包管理文件
├── composer.lock                   锁定包管理文件
├── conf                            nginx、fpm、php配置文件所在目录  
├── config                          缓存、日志等常用配置目录
├── public                          资源所在目录
├── route                           路由文件所在目录
├── run.sh                          启动命令脚本
├── runtime                         日志所在目录
├── think                           应用初始化文件
└── vendor                          下载的依赖所在目录
```

### LICENSE
MIT