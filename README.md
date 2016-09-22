# PHPIncluder

A minimalistic PHP framework for include/require

## features

* Auto global include
* application root path
* smart path join

## Installation

Via composer:
```
composer require tomaskraus/php-includer
```
, or include this snippet to `composer.json`
```json    
    "require": {        
        "tomaskraus/php-includer": "^0.3"
    },
```

## PHPIncluder usage

1. **Use as a library**: Create a new `PI` (php includer) instance with your application root path as a parameter.
2. **Use as a framework**: Include `piLoader.php` in your requested page. It guesses your application root path and creates a new PI instance (a `$pi` variable) with that path guessed. 

Assume we have our php application in `/var/www/myApp`. A `/var/www/myApp` is our application root path (`./`). 

example: file `./index.php`
```php
<?php
//A loader. Guesses an application root path and initializes a PhpIncluder instance.
require_once "./vendor/tomaskraus/php-includer/piLoader.php";

//once piLoader is included, a php-includer object ($pi) is available

//provides a web application root path
echo $pi->path(); //echoes "/var/www/myApp/"

//we can create new, non-existing path strings, based on a web application root
$pi->path("conf/file-to-be-created.php"); //returns "/var/www/myapp/conf/file-to-be-created.php".

//path-safe include, wherever you are
include $pi->path("myLib/utils.php"); //includes /var/www/myapp/myLib/utils.php

//smart path join, fixes missing or too many separators
PI::joinPath("myapp/", "/dist/app.zip"); //returns "myapp/dist/app.zip"
PI::joinPath("/var/www", "dist/app.zip"); //returns "/var/www/dist/app.zip", preserves a root slash
//join Windows path
PI::joinPath("C:\\www\\", "/dist/app.zip"); //returns "C:\\www/dist/app.zip", mixed result for Windows path (still works in PHP) 
PI::joinPath("C:\\www", "dist/app.zip"); //returns the same...
```
**example**: file `./login/index.php`
```php
<?php
//require piLoader
//we are not in application root directory, so we changed the path accordingly
require_once "./../vendor/tomaskraus/php-includer/piLoader.php";

//once piLoader is included, a php-includer object ($pi) is available

//provides a web application root path, even if you are not in application root directory
echo $pi->path(); //echoes "/var/www/myapp/"

//path-safe include, wherever you are (now we are in the "login" subdirectory)
include $pi->path("myLib/utils.php"); //includes /var/www/myapp/myLib/utils.php

```

### Auto global include

If there is a `pi.global.php` file in the application root directory, it is automatically included, wherever you include/require `piLoader`, regardless of (sub)directory.

**example**: file `./pi.global.php`
```php
<?php

//here you can already use a php-includer object, it is already included 
include $pi->path("conf/config.php"); //includes /var/www/myapp/conf/config.php


//This file is a right place to write the class auto loader
$autoLoaderFile = __DIR__ . "/vendor/autoload.php";
if (file_exists($autoLoaderFile)) {
    require_once $autoLoaderFile;
}

```
