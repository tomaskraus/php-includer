<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PhpIncluder\Test;

use \PhpIncluder\PI;

/**
 * Description of PathTest
 *
 * @author Tomáš
 */
class PathTest extends \PHPUnit_Framework_TestCase {
    
    protected $p;
    const ROOT_PATH = "/myAppRoot";
    
    protected function setUp()
    {
        $this->p = new PI(self::ROOT_PATH);
    }  
    
    public function test_no_added_path() {        
        $this->assertEquals(self::ROOT_PATH, $this->p->path());
    }
    
    public function test_non_empty_added_path() {        
        $this->assertEquals(self::ROOT_PATH . "/user/login.php", $this->p->path("user/login.php"));
    }
    
}
