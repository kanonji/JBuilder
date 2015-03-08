<?php
use JBuilder\Common\JSON;
$json = new JSON([
    'key' => 'value',
]);
$json->list($partial->ary, function($json, $item){
    $json->id = $item['id'];
    $json->name = $item['name'];
    // $json->extra = $item['extra'];
});
return $json;
