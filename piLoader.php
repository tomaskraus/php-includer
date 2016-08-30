<?php

namespace PhpIncluder;

// vendor/tomaskraus/php-includer
$LOADER_RELATIVE_PATH_TO_APP_ROOT = "../../..";

//auto-loader
$autoLoader = __DIR__ . "/" . $LOADER_RELATIVE_PATH_TO_APP_ROOT . "/vendor/autoload.php";
if (file_exists($autoLoader)) {
    require $autoLoader;
}

require_once "src/PI.php";

//root object
$pi = new PI();

//include file in app root dir
$fileToIncludeAlways = $pi->path("pi.global.php");
if (file_exists($fileToIncludeAlways)) {
    include_once $fileToIncludeAlways;
}

//within the directory of a top-level includer
$fileToIncludeOnDirectoryLevel = "pi.dir.php";
if (file_exists($fileToIncludeOnDirectoryLevel)) {
    include_once $fileToIncludeOnDirectoryLevel;
}
