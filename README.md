# PHPIncluder

A minimalistic PHP library for include/require

### features

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
$PI::joinPath("myapp", "dist/app.zip"); //returns "myapp/dist/app.zip"
$PI::joinPath("myapp/", "/dist/app.zip"); //returns "myapp/dist/app.zip"
$PI::joinPath("/var/www", "dist/app.zip"); //returns "/var/www/dist/app.zip", preserves a root slash
```
 