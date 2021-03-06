# Thrift-Silex
[![Build Status](https://travis-ci.org/thbourlove/thrift-silex.png?branch=master)](https://travis-ci.org/thbourlove/thrift-silex)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thbourlove/thrift-silex/badges/quality-score.png?s=f113f1ab965f6aaef55e497a330caf72bff94201)](https://scrutinizer-ci.com/g/thbourlove/thrift-silex/)
[![Code Coverage](https://scrutinizer-ci.com/g/thbourlove/thrift-silex/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/thbourlove/thrift-silex/?branch=master)
[![Stable Status](https://poser.pugx.org/eleme/thrift-silex/v/stable.png)](https://packagist.org/packages/eleme/thrift-silex)

thrift service provider for silex framework.

## Install With Composer:

```json
"require": {
    "eleme/thrift-silex": "~0.1"
}
```

## Example:
```php
use Silex\Application;
use Eleme\Thrift\Provider\Silex\ThriftServiceProvider;

$app = new Application;
$app->register(new ThriftServiceProvider);
$app['thrift.options'] = array(
    'foo' => array(
        'server' => 'foo_host',
        'port' => 12345,
        'client' => 'FooClient'
    ),
    'bar' => array(
        'server' => 'bar_host',
        'port' => 12346,
        'client' => 'BarClient'
    ),
);
$app['thrift.clients']['foo']->api();
$app['thrift.clients']['bar']->api();
```
