<?php
namespace JBuilder\Common\Tests\PartialTest;
use JBuilder\Common\Encoder;
use JBuilder\Common\Partial;

class Foo{
    public $name = 'foo';
    public $date = '2000-01-01';
}

class PartialTest extends \PHPUnit_Framework_TestCase {

    public function testPartial_objectDirectly() {
        $result = Encoder::encode(function($json) {
            $obj = new Foo;
            $json->root = Partial::load(dirname(__FILE__).'/partial/simply_use_obj.json.php', ['foo' => $obj]);
        });

        $this->assertEquals('{"root":{"obj":{"name":"foo","date":"2000-01-01"},"key":"value"}}', $result);
    }

    public function testPartial_setPartialDir() {
        $result = Encoder::encode(function($json) {
            $obj = new Foo;
            Partial::$dir = dirname(__FILE__).'/partial';
            $json->root = Partial::load('simply_use_obj.json.php', ['foo' => $obj]);
        });

        $this->assertEquals('{"root":{"obj":{"name":"foo","date":"2000-01-01"},"key":"value"}}', $result);
    }

    public function testPartial_non_existed_key_is_null() {
        $result = Encoder::encode(function($json) {
            $obj = new Foo;
            Partial::$dir = dirname(__FILE__).'/partial';
            $json->root = Partial::load('non_existed_key_is_null.json.php', ['foo' => $obj]);
        });

        $this->assertEquals('{"root":{"obj":null,"key":"value"}}', $result);
    }

    public function testPartial_filter_some_key_in_multi_array() {
        $result = Encoder::encode(function($json) {
            $ary = [
                ['id' => 1, 'name' => 'item1', 'extra' => 'foo'],
                ['id' => 2, 'name' => 'item2', 'extra' => 'bar'],
            ];
            Partial::$dir = dirname(__FILE__).'/partial';
            $json->root = Partial::load('filter_some_key_in_multi_array.json.php', ['ary' => $ary]);
        });

        $this->assertEquals('{"root":{"key":"value","list":[{"id":1,"name":"item1"},{"id":2,"name":"item2"}]}}', $result);
    }

    public function testPartial_use_in_closure() {
        $result = Encoder::encode(function($json) {
            $ary1 = [
                ['id' => 1],
                ['id' => 2],
            ];
            $ary2 = [
                ['id' => 10],
                ['id' => 20],
                ['id' => 30],
            ];
            Partial::$dir = dirname(__FILE__).'/partial';
            $json->root = Partial::load('use_in_closure.json.php', ['ary1' => $ary1, 'ary2' => $ary2]);
        });

        $this->assertEquals('{"root":{"key":"value","count":{"ary1":2,"ary2":3}}}', $result);
    }
}
