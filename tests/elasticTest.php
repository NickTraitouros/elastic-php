<?php

require_once('elastic.php');

class ElasticTest extends PHPUnit_Framework_TestCase {

    public $elastic;

    public function setUp() {
        $this->elastic = new elastic('http://ec2-52-7-205-221.compute-1.amazonaws.com','9200');
    }

    public function testAddAndRemoveIndex() {
         $this->assertEquals('{"acknowledged":true}',$this->elastic->add_index('mammals'));
         $this->assertEquals('{"acknowledged":true}',$this->elastic->delete_index('mammals'));
    }

    public function testAddAndRemoveMapping() {

    }

}