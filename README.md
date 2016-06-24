# 阿里大鱼SDK

## composer 安装

```shell
composer require cdcchen/dayu-client:^1.0.0
```

## 使用教程


### 实例化Client

```
$appKey = '22222237';
$secret = 'ed9cf1d59w32f2b90ab3453454ad2d';
$client = new \cdcchen\alidayu\Client($appKey, $secret);
```


## 发送短信接口

### 实例化 Request

```
$request = new \cdcchen\alidayu\SmsSendRequest();
$request->setSmsType('normal')
        ->setSmsFreeSignName('签名')
        ->setSmsTemplateCode('SMS_10545142')
        ->setSmsParams(['code' => '23543', 'product' => 'XXXXX'])
        ->setReceiveNumber('1895xxxx700')
        ->setExtend('123wehnergre');
```


### 发送请求

```
use cdcchen\alidayu\ResponseException;
use Exception;

try {
    $response = $client->execute($request);
    $data = $response->getData();

} catch (ResponseException $e) {
    echo $e->getMessage(), PHP_EOL;
    echo $e->getCode(), PHP_EOL;
    echo $e->getSubCode(), PHP_EOL;
    echo $e->getSubMsg(), PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
    echo $e->getCode(), PHP_EOL;
}
finally {
    echo 'Send sms complete.', PHP_EOL;
}
```


## 查询短信日志接口

### 实例化 Request

```php
$request = new \cdcchen\alidayu\SmsQueryRequest();
$request->setReceiveNumber('186xxxx7700')
        ->setBizId('101788701356^1102414566772')
        ->setQueryDate('20160614')
        ->setCurrentPage(1)
        ->setPageSize(1);
```

### 发送请求

```php
use cdcchen\alidayu\ResponseException;
use Exception;

try {
    $response = $client->execute($request);

    $data = $response->getData();
    $items = $response->getItems();

} catch (ResponseException $e) {
    echo $e->getMessage(), PHP_EOL;
    echo $e->getCode(), PHP_EOL;
    echo $e->getSubCode(), PHP_EOL;
    echo $e->getSubMsg(), PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
    echo $e->getCode(), PHP_EOL;
}
finally {
    echo 'Send sms complete.', PHP_EOL;
}
```