<?php

namespace PhpIncluder\Test;

$returnValFromRequire;

/**
 * Description of PathTest
 *
 * @author Tomáš
 */
class BootstrapFileIncludeTest extends \PHPUnit_Framework_TestCase {

    protected $p;
    const ROOT_PATH = "/myAppRoot";


    protected function setUp() {
        global $returnValFromRequire;
        $returnValFromRequire = 1;
    }


    public function testBootstrapFileInclude() {
        global $returnValFromRequire;
        $this->assertEquals(1, $returnValFromRequire);

        //provide own PI (php-includer) instance for testing
        $pi = new \PhpIncluder\PI(__DIR__);
        include_once __DIR__ . "/../../piLoader.php";
        $this->assertEquals(42, $returnValFromRequire);
    }

}

