# PHPIncluder

A minimalistic PHP library for include/require

## features

* Auto global include
* Auto include, based on a directory 

* application root path

```php
//assume our web app absolute path is "/var/www/myapp"

$pi->path(); //returns "/var/www/myapp"
$pi->path("conf/user.php"); //returns "/var/www/myapp/conf/user.php"
$pi->path("/conf/user.php"); //the same...
``` 

* smart path join, even for non-existent paths

```php
PI::joinPath("myapp", "dist/app.zip"); //returns "myapp/dist/app.zip"
PI::joinPath("myapp/", "/dist/app.zip"); //returns "myapp/dist/app.zip"
PI::joinPath("/var/www", "dist/app.zip"); //returns "/var/www/dist/app.zip", preserves a root slash

//note: PI::joinPath does not recognize Windows separator (backslash) 
```

## Installation

via composer. include this snippet to composer.json
```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/tomaskraus/php-includer"
        }
    ],
    "require": {        
        "tomaskraus/php-includer": "@alpha"
    },
```

## PHPIncluder usage

Assume we have our php application in `/var/www/myApp`. A `/var/www/myApp` dir is our application root directory (`./`). 

example: `./index.php`
```php
<?php
//require piLoader
require_once "./vendor/tomaskraus/php-includer/piLoader.php";

//once piLoader is included, a php-includer object ($pi) is available

//provides root path
echo $pi->path(); //string

//one can also append to root path
include $pi->path("myLib/utils.php")

```

**example**: `./login/index.php`
```php
<?php
//require piLoader
//if not in application root directory, change the path accordingly
require_once "./../vendor/tomaskraus/php-includer/piLoader.php";

//once piLoader is included, a php-includer object ($pi) is available

//provides root path, even if you are not in application root directory
echo $pi->path(); //string

//one can also append to root path
//still works, even if you are not in application root directory
include $pi->path("myLib/utils.php")

```

## Auto global include

If there is a `pi.global.php` file in the application root directory, it is automatically included, wherever you include/require `piLoader`, regardless of (sub)directory.

**example**: `./pi.global.php`
```php
<?php

//class auto loader
$autoLoaderFile = __DIR__ . "/vendor/autoload.php";
if (file_exists($autoLoaderFile)) {
    require_once $autoLoaderFile;
}

//here you can already use a php-includer object, even if you have not included it 
include $pi->path("conf/config.php")
```

From the previous examples, `./pi.global.php` will be included in both `./index.php and` `./login/index.php` files.

## Auto include, based on a directory

If there is a `pi.dir.php` file in a `directory`, it is automatically included, wherever you include/require `piLoader` in php files in that `directory`.

**example**: `./user/pi.dir.php`
```php
<?php
//here you can already use a php-includer object, even if you have not included the piLoader 
include $pi->path("conf/config.php")

//restrict the access
if (userIsNotLoggedIn) {
    showLoginPage();
    exit;
}
```

`./user/pi.dir.php` will be applied to all files in the (and only) `./user` directory that includes the `piLoader`.

**note**: `pi.dir.php` inclusion behavior does not act recursively - that is, no eventual `pi.dir.php` from parent directory is included
