# php-includer

A minimalistic PHP library/framework for include/require

## features

* application root path
* smart path join
* "bootstrap" file auto include

## Installation

Via composer:
```
composer require tomaskraus/php-includer
```
, or add this snippet to `composer.json`
```json
    "require": {
        "tomaskraus/php-includer": "^0.4"
    },
```

## php-includer usage options

1. **Use as a library**: Create a new `PI` (php includer) instance with your application root path as a parameter.
2. **Use as a framework**: Include `piLoader.php` in your requested page.
It guesses your application root path and creates a new PI instance (a `$pi` variable) with that path guessed.
It also automatically includes an user-defined "bootstrap" file (`pi.bootstrap.php`), an ideal place for your specific initialization piece of code.

### application root path guess logic
1. `piLoader.php` assumes that it is in a `vendor/tomaskraus/php-include` directory.
2. `piLoader.php` assumes that a `vendor` directory is in the application root directory.

## php-includer framework examples

Assume we have our php application in `/var/www/myApp`. A `/var/www/myApp` is our application root path (`./`).

example 1: php-includer in the `./index.php` file
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
**example 2**: php-includer in the `./login/index.php` file
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

### bootstrap file

You can create a `pi.bootstrap.php` file in the application root directory and put whatever you want in it.
That bootstrap file will be automatically included, wherever you include/require `piLoader`, regardless of (sub)directory.
A bootstrap file is an ideal place for your specific initialization piece of code.

**note:** this bootstrap file has nothing to do with the [Bootstrap CSS framework](http://getbootstrap.com/)

`pi.bootstrap.php` file example: assume we have a `pi.bootstrap.php` file in `/var/www/myapp` directory:
```php
<?php

//here you can already use a php-includer ($pi) object, it is already included
include $pi->path("conf/config.php"); //includes /var/www/myapp/conf/config.php


//This bootstrap file is a right place to write the class auto loader here
$autoLoaderFile = __DIR__ . "/vendor/autoload.php";
if (file_exists($autoLoaderFile)) {
    require_once $autoLoaderFile;
}

//other, globally needed stuff...

```

This bootstrap file will be automatically included in both `./index.php` and `./login/index.php` files from previous examples.

