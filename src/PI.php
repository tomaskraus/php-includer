<?php

namespace PhpIncluder;

/**
 * Description of Lw
 *
 * @author Tomáš
 */
class PI {
    
    // vendor/tomaskraus/php-includer/src
    const PI_RELATIVE_PATH_TO_APP_ROOT = "/../../../..";

    private $root;

    public function __construct($rootPath = null) {
        if ($rootPath) {
            $this->root = $rootPath;
        } else {
            $this->root = realpath(__dir__ . self::PI_RELATIVE_PATH_TO_APP_ROOT);
        }
    }

    public function path($path = null) {
        return self::joinPath($this->root, $path);
    }

    /**
     * 
     * @param string path1 
     * @param string path2 
     * @return string correct path (with auto inserted/deleted path separator)
     */
    public static function joinPath($path1, $path2) {
        $final_delim = "/";
        $path1Orig = $path1;
        if (!$path1) {
            $path1 = "";
        }
        if (!$path2) {
            $path2 = "";
        }

        $path1 = trim($path1, "/");
        $path2 = trim($path2, "/");
        $path1 = trim($path1, "\\");
        $path2 = trim($path2, "\\");

        //preserve the root (Linux, Mac)
        $startChar = substr($path1Orig, 0, 1);
        if ($startChar == "/") {
            $path1 = $final_delim . $path1;
        }

        if (!$path1 && !$path2) {
            return "";
        } else if (!$path1) {
            return $path2;
        } else if (!$path2) {
            return $path1;
        } else {
            return $path1 . $final_delim . $path2;
        }
    }

}
