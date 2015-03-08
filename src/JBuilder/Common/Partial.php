<?php
namespace JBuilder\Common;

class Partial {

    public static $dir;

    private $data;

    public function __construct($data = null) {
        $this->data = $data;
    }

    public function __get($key){
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public static function load($_filepath, $args = []){
        if(self::$dir) $_filepath = join(DIRECTORY_SEPARATOR, [realpath(self::$dir), $_filepath]);
        $partial = new Partial($args);
        return include($_filepath);
    }
}
