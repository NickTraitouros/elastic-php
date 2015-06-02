<?php

require_once('elastic.php');

class ElasticTest extends PHPUnit_Framework_TestCase {

    public $elastic;

    public function setUp() {
        $this->elastic = new elastic('http://ec2-52-7-205-221.compute-1.amazonaws.com','9200');
        define("ACKNOWLEDGED", '{"acknowledged":true}');
    }

    public function testAddAndRemoveIndex() {
         $this->assertEquals(ACKNOWLEDGED, $this->elastic->add_index('mammals'));
         $this->assertEquals(ACKNOWLEDGED, $this->elastic->delete_index('mammals'));
    }

    public function testAddAndRemoveMapping() {

         $mapping = '
         {
            "properties" : {
                "size" : {"type" : "string", "store" : true, "index": "not_analyzed"},
                "color" : {"type" : "string", "store" : true, "index": "not_analyzed"}
            }
         }';

         $this->assertEquals(ACKNOWLEDGED, $this->elastic->add_index('mammals'));
         $this->assertEquals(ACKNOWLEDGED, $this->elastic->add_mapping('mammals','mice', $mapping));
         $this->assertEquals(ACKNOWLEDGED, $this->elastic->delete_mapping('mammals','mice'));
         $this->assertEquals(ACKNOWLEDGED, $this->elastic->delete_index('mammals'));
    }




}