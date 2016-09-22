<?php

namespace PhpIncluder;

require_once "src/PI.php";

//root object
$pi = new PI();

//include file in app root dir
$fileToIncludeAlways = $pi->path("pi.global.php");
if (file_exists($fileToIncludeAlways)) {
    include_once $fileToIncludeAlways;
}

