#Config4all

[![Downloads with Composer](https://poser.pugx.org/masnathan/config4all/downloads.png)](https://packagist.org/packages/masnathan/config4all)
[![SensioLabs Insight](https://insight.sensiolabs.com/projects/039f5b95-8883-4342-9695-8f86d58fef09/mini.png)](https://insight.sensiolabs.com/projects/039f5b95-8883-4342-9695-8f86d58fef09)
[![ReiDuKuduro @gittip](http://bottlepy.org/docs/dev/_static/Gittip.png)](https://www.gittip.com/ReiDuKuduro/)

This class helps you load your application configs, it supports php, xml, ini, yml and json files.

It's easy to use, and you can load multiple files with diferent formats at once

# How to install via Composer

The recommended way to install is through [Composer](http://composer.org).

```sh
# Install Composer
$ curl -sS https://getcomposer.org/installer | php

# Add Config4all as a dependency
$ php composer.phar require masnathan/config4all:dev-master
```

Once it's installed, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

##How it works

You can check a few config examples [here](tests/configs) 

###Loading and unloading content

```php
$config = MASNathan\Config\Config();

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

###Fetching the information
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

###Setting my own configs
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

# License

This library is under the MIT License, see the complete license [here](LICENSE)

###Is your project using `Config4all`? [Let me know](https://github.com/ReiDuKuduro/Config4all/issues/new?title=New%20script%20using%20Config4all&body=Name and Description of your script.)!