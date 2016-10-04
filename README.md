# Config4all

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masnathan/config4all.svg?style=flat-square)](https://packagist.org/packages/masnathan/config4all)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/MASNathan/Config4all/master.svg?style=flat-square)](https://travis-ci.org/MASNathan/Config4all)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/masnathan/config4all.svg?style=flat-square)](https://scrutinizer-ci.com/g/masnathan/config4all/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/masnathan/config4all.svg?style=flat-square)](https://scrutinizer-ci.com/g/masnathan/config4all)
[![Total Downloads](https://img.shields.io/packagist/dt/masnathan/config4all.svg?style=flat-square)](https://packagist.org/packages/masnathan/config4all)
[![Support via Gittip](https://img.shields.io/gittip/ReiDuKuduro.svg?style=flat-square)](https://gratipay.com/~ReiDuKuduro/)

This class helps you load your application configs, it supports php, xml, ini, yml, neon and json files.

It's easy to use, and you can load multiple files with diferent formats at once

## Install

Via Composer

``` bash
$ composer require masnathan/config4all
```

## Usage

``` php
use MASNathan\Config\Config;

$config = new Config();

//You can load as many files as you want, one by one
$config->load('configs/config.php', 'configs/database.php');
//or all the files with a certain extension at the same time
$config->load('configs/*.json');
//you can even load multiple format files at the same time
$config->load('configs/*.json', 'configs/*.yml');
//or can also load multiple files, regardless of the extension
$config->load('configs/*.*');

//This is how you clear all the configurations
$config->clear();
```

##Fetching the information
```php
//To get a value, you just need to know the path to get there
//if you want to know my name, just use the get method and pass the configuration file name
//and the keys to get my name, like this
echo $config->get('config', 'me', 'name');

//here are some other examples
echo $config->get('config', 'github');
echo $config->get('database', 'host');

//if the value that you are trying to get doesn't exist, you'll get a null
//you can also get the entire structure by calling the method get with no arguments
var_dump($config->get());
```

##Setting my own configs
```php
//You can also set new configs on the fly, or change existing ones
$config
    ->set('a', 'b', 'c', 'value')
    ->set('config', 'me', 'name', 'Not Andre Filipe')
    ->set('database', 'host', 'first', 'localhost')
    ->set('database', 'host', 'second', 'somehost')
    ->set('this is a null field');

//This will return 'value'
echo $config->set('a', 'b', 'c');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email andre.r.flip@gmail.com instead of using the issue tracker.

## Credits

- [André Filipe](https://github.com/masnathan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
