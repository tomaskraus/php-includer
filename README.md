# PHPIncluder

A minimalistic PHP framework for include/require

**note**: Do not use PHPIncluder in libraries, it may not work as expected...

## features

* Auto global include
* application root path
* smart path join

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

Assume we have our php application in `/var/www/myApp`. A `/var/www/myApp` is our application root directory (`./`). 

example: file `./index.php`
```php
<?php
//require piLoader
require_once "./vendor/tomaskraus/php-includer/piLoader.php";

//once piLoader is included, a php-includer object ($pi) is available

//provides a web application root path
echo $pi->path(); //echoes "/var/www/myapp/"

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

**example**: `./pi.global.php`
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

From the previous examples, `./pi.global.php` will be included in both `./index.php and` `./login/index.php` files.
