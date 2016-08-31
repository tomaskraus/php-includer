# PHPIncluder

A minimalistic PHP library for include/require

## features

* Auto global include
* Auto include, based on a directory 
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

example: `./index.php`
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
include $pi->path("myLib/utils.php"); //includes /var/www/myapp/conf/utils.php

//smart path join, fixes missing or too many separators
PI::joinPath("myapp/", "/dist/app.zip"); //returns "myapp/dist/app.zip"
PI::joinPath("/var/www", "dist/app.zip"); //returns "/var/www/dist/app.zip", preserves a root slash
//join Windows path
PI::joinPath("C:\\www\\", "/dist/app.zip"); //returns "C:\\www/dist/app.zip", mixed result for Windows path (still works in PHP) 
PI::joinPath("C:\\www", "dist/app.zip"); //returns the same...
```
**example**: `./login/index.php`
```php
<?php
//require piLoader
//we are not in application root directory, so we changed the path accordingly
require_once "./../vendor/tomaskraus/php-includer/piLoader.php";

//once piLoader is included, a php-includer object ($pi) is available

//provides a web application root path, even if you are not in application root directory
echo $pi->path(); //echoes "/var/www/myapp/"

//path-safe include, wherever you are (now we are in the "login" subdirectory)
include $pi->path("myLib/utils.php"); //includes /var/www/myapp/conf/utils.php

```

### Auto global include

If there is a `pi.global.php` file in the application root directory, it is automatically included, wherever you include/require `piLoader`, regardless of (sub)directory.

**example**: `./pi.global.php`
```php
<?php

//class auto loader
$autoLoaderFile = __DIR__ . "/vendor/autoload.php";
if (file_exists($autoLoaderFile)) {
    require_once $autoLoaderFile;
}

//here you can already use a php-includer object, it is already included 
include $pi->path("conf/config.php");
```

From the previous examples, `./pi.global.php` will be included in both `./index.php and` `./login/index.php` files.

### Auto include, based on a directory

If there is a `pi.dir.php` file in a `directory`, it is automatically included, wherever you include/require `piLoader` in php files in that `directory`.

**example**: `./user/pi.dir.php`
```php
<?php
//here you can already use a php-includer object, it is already included
include $pi->path("conf/config.php");

//restrict the access
if (userIsNotLoggedIn) {
    require $pi->path("login/index.php"); //requires "/var/www/myApp/login/index.php"
}
```

`./user/pi.dir.php` will be applied to all files in (and only) the `./user` directory that includes the `piLoader`.

**note**: `pi.dir.php` inclusion behavior does not act recursively - that is, no eventual `pi.dir.php` from parent directory is included

## Notes
### including other apps
If two different apps use a PHPIncluder and one app includes the second one, PHPIncluder may not work as expected.

