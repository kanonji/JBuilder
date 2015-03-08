<?php
namespace JBuilder\Common\Tests\AdditionalTest;
use JBuilder\Common\Encoder;
use JBuilder\Common\JSON;

class Foo{
    public static $public_static_member = 'public';
    protected static $protected_static_member = 'protected';
    private static $private_static_member = 'private';

    public $public_member = 'public';
    protected $protected_member = 'protected';
    private $private_member = 'private';

    public function public_method(){}
    protected function protected_method(){}
    private function private_method(){}
}

class TryTest extends \PHPUnit_Framework_TestCase {

    public function testAdditional_ArrayDirectly() {
        $result = Encoder::encode(function($json) {
            $json->list = [1, 2, 3];
        });

        $this->assertEquals('{"list":[1,2,3]}', $result);
    }

    public function testAdditional_HashDirectly() {
        $result = Encoder::encode(function($json) {
            $json->list = [
                ['id' => 1, 'name' => 'foo'],
                ['id' => 2, 'name' => 'bar'],
            ];
        });

        $this->assertEquals('{"list":[{"id":1,"name":"foo"},{"id":2,"name":"bar"}]}', $result);
    }

    public function testAdditional_stdclass() {
        $result = Encoder::encode(function($json) {
            $obj = new \stdclass;
            $obj->name = 'foo';
            $obj->title = 'bar';
            $json->obj = $obj;
        });

        $this->assertEquals('{"obj":{"name":"foo","title":"bar"}}', $result);
    }

    public function testAdditional_obj() {
        $result = Encoder::encode(function($json) {
            $obj = new Foo;
            $json->obj = $obj;
        });

        $this->assertEquals('{"obj":{"public_member":"public"}}', $result);
    }

    public function testAdditional_HashByJsonObj() {
        $result = Encoder::encode(function($json) {
            $obj = new JSON([
                'name' => 'foo',
                'title' => 'bar',
            ]);
            $json->obj = $obj;
        });

        $this->assertEquals('{"obj":{"name":"foo","title":"bar"}}', $result);
    }

    public function testAdditional_NestedArrayByJsonObj() {
        $result = Encoder::encode(function($json) {
            $obj = new JSON([
                ['id' => 1, 'name' => 'foo'],
                ['id' => 2, 'name' => 'bar'],
            ]);
            $json->obj = $obj;
        });

        $this->assertEquals('{"obj":[{"id":1,"name":"foo"},{"id":2,"name":"bar"}]}', $result);
    }
}
