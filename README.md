<h1 align="center">😆Git Notify😆</h1>

<p align="center">
git 代码推送通知
</p>

在公司进行开发时，如何**优雅而又不尴尬**的让老板知道自己每天几点下班，好让老板加工资，这是一个问题。

现在应该基本每个公司用钉钉，而钉钉又有机器人可以自动推送，😆，git 可以使用 webhook，于是，就有了这样一个系统。

## 特性
1. 隐藏不需要关心的内部流程
2. 可以随意增加现有类库中没有的服务

## 支持的服务
### git 提供商
- gitee （码云）

### IM 消息推送服务
- dingtalk （钉钉）

## 安装
`composer require yansongda/git_notify`

## 使用方法
```php
<?php

require './vendor/autoload.php';

$app = new Yansongda\GitNotify\Application();
$app->from->setPassword('88793650');
//$app->destination->gateway = 'https://oapi.dingtalk.com/robot/send?access_token=36c01ca8552fa8f9f6xxxxx';

$response = $app->destination->send();
$app->log->info('发送结果：', $response->getBody()->getContents());
```

## LICENSE
MIT