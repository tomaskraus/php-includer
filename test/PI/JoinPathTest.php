<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PhpIncluder\Test;

use \PhpIncluder\PI;

/**
 * Description of PITest
 *
 * @author Tomáš
 */
class PITest extends \PHPUnit_Framework_TestCase {

    public function test_empty_if_both_args_are_null() {        
        $this->assertEquals("", PI::joinPath(null, null));
    }
    
    public function test_empty_if_arg_is_either_empty_or_null() {        
        $this->assertEquals("", PI::joinPath("", null));
        $this->assertEquals("", PI::joinPath(null, ""));
        $this->assertEquals("", PI::joinPath("", ""));
    }
    
    public function test_returns_first_if_second_is_empty() {        
        $this->assertEquals("abc", PI::joinPath("abc", null));
        $this->assertEquals("abc", PI::joinPath("abc", ""));       
    }
    
    public function test_returns_second_if_first_is_empty() {        
        $this->assertEquals("abc", PI::joinPath(null, "abc"));
        $this->assertEquals("abc", PI::joinPath("", "abc"));
        
        $this->assertEquals("abc", PI::joinPath(null, "/abc"));
        $this->assertEquals("abc", PI::joinPath("", "/abc"));
    }
    
    public function test_returns_without_trailing_delimiter() {
        $this->assertEquals("abc", PI::joinPath("abc/", null));
        $this->assertEquals("abc", PI::joinPath("abc/", ""));
        
        $this->assertEquals("abc", PI::joinPath(null, "abc/"));
        $this->assertEquals("abc", PI::joinPath("", "abc/"));
        
        $this->assertEquals("abc", PI::joinPath(null, "/abc/"));
        $this->assertEquals("abc", PI::joinPath("", "/abc/"));        
    }
    
    
    public function test_returns_delimiter_between_two_non_empty_args() {        
        $this->assertEquals("abc/def", PI::joinPath("abc", "def"));
        
        $this->assertEquals("abc/def", PI::joinPath("abc/", "def"));
        $this->assertEquals("abc/def", PI::joinPath("abc", "/def"));
        $this->assertEquals("abc/def", PI::joinPath("abc/", "/def"));                
    }
    
    public function test_preserve_root_delimiter_first_arg() {
        $this->assertEquals("/", PI::joinPath("/", null));
        $this->assertEquals("/", PI::joinPath("/", ""));
        
        $this->assertEquals("/abc", PI::joinPath("/abc", ""));
        $this->assertEquals("/abc", PI::joinPath("/abc", null));
        $this->assertEquals("/abc", PI::joinPath("/abc/", ""));
        $this->assertEquals("/abc", PI::joinPath("/abc/", null));
        
        $this->assertEquals("/abc/d", PI::joinPath("/abc", "d"));
        $this->assertEquals("/abc/d", PI::joinPath("/abc", "/d"));
    } 
    
    public function test_windows_delimiters() {
        $this->assertEquals("", PI::joinPath("\\", null));
        $this->assertEquals("", PI::joinPath("\\", ""));
        
        $this->assertEquals("abc", PI::joinPath("\\abc", ""));
        $this->assertEquals("abc", PI::joinPath("abc\\", null));
        $this->assertEquals("abc", PI::joinPath("\\abc\\", ""));
        
        $this->assertEquals("c:\\abc\\d/e", PI::joinPath("c:\\abc\\d", "e"));
        $this->assertEquals("c:\\abc\\d/e", PI::joinPath("c:\\abc\\d", "/e"));
        $this->assertEquals("c:\\abc\\d/e", PI::joinPath("c:\\abc\\d", "\\e"));
        
        $this->assertEquals("c:\\abc\\d/e", PI::joinPath("c:\\abc\\d\\", "e"));
        $this->assertEquals("c:\\abc\\d/e", PI::joinPath("c:\\abc\\d\\", "/e"));
        $this->assertEquals("c:\\abc\\d/e", PI::joinPath("c:\\abc\\d\\", "\\e"));
    } 
}

