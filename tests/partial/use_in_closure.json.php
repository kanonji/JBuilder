<?php
use JBuilder\Common\JSON;
$json = new JSON([
    'key' => 'value',
]);
$json->count(function($json) use ($partial) {
    $json->ary1 = count($partial->ary1);
    $json->ary2 = count($partial->ary2);
});
return $json;
