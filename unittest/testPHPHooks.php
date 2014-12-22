<?php
/**
 * @Author: Amin by
 * @Date:   2014-12-09 10:42:32
 * @Last Modified by:   Amin by
 * @Last Modified time: 2014-12-09 17:03:11
 */
require dirname(__DIR__) . '/.php';

class phphooksTest extends PHPUnit_Framework_TestCase {

  function testUniqueId() {
    $hooks = new PHPHooks;

    $a = $hooks->unique_id('test_function');
    $b = $hooks->unique_id('test_function');
    $this->assertTrue(is_string($a), 'is string');
    $this->assertTrue(is_string($b), 'is string');
    $this->assertTrue($a == $b, 'is equal');


    $a = $hooks->unique_id(array($));
    $b = $hooks->unique_id(array($));
    $this->assertTrue(is_string($a), 'is string');
    $this->assertTrue(is_string($b), 'is string');
    $this->assertTrue($a == $b, 'is equal');
  }
}