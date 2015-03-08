# Forked JBuilder for PHP [![Build Status](https://travis-ci.org/kanonji/JBuilder.svg?branch=master)](https://travis-ci.org/kanonji/JBuilder)

This is fork from https://github.com/dakatsuka/JBuilder to add basic partial support for myself.

## Basic Partial

```php
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
```

This is partial template named `filter_some_key_in_multi_array.json.php`.


```php
$result = Encoder::encode(function($json) {
    $ary = [
        ['id' => 1, 'name' => 'item1', 'extra' => 'foo'],
        ['id' => 2, 'name' => 'item2', 'extra' => 'bar'],
    ];
    Partial::$dir = dirname(__FILE__).'/partial';
    $json->root = Partial::load('filter_some_key_in_multi_array.json.php', ['ary' => $ary]);
});
```

This will build the following structure:

```json
{
  "root":{
    "key":"value",
    "list":[
      {
        "id":1,
        "name":"item1"
      },
      {
        "id":2,
        "name":"item2"
      }
    ]
  }
}
```


## Original README hereunder

This is a library for creating the structure of the JSON for PHP.

```php
use JBuilder\Common\Encoder;

echo Encoder::encode(function($json) use ($comments) {
    $json->title = "This is a pen";
    $json->created_at = (new \DateTime())->format(\DateTime::ISO8601);
    $json->updated_at = (new \DateTime())->format(\DateTime::ISO8601);

    $json->author(function($json) {
        $json->name  = "Dai Akatsuka";
        $json->email = "d.akatsuka@gmail.com";
        $json->url   = "https://github.com/dakatsuka";
    });

    $json->comments($comments, function($json, $comment) {
        $json->content    = $comment->getContent();
        $json->created_at = $comment->getCreatedAt();
    });
});
```

This will build the following structure:

```json
{
  "title": "This is a pen",
  "created_at": "2013-05-21T16:49:37+0900",
  "updated_at": "2013-05-21T16:49:37+0900",

  "author": {
    "name": "Dai Akatsuka",
    "email": "d.akatsuka@gmail.com",
    "url": "https://github.com/dakatsuka"
  },
  
  "comments": [
    {
      "content": "Hello! Great!",
      "created_at": "2013-05-21T16:49:37+0900"
    },
    {
      "content": "Hello! Great!",
      "created_at": "2013-05-21T16:49:37+0900"
    }
  ]
}
```


## Installation

Add this lines to your composer.json:

```json
{
    "require": {
        "jbuilder/common": "dev-master"
    }
}
```

And then execute:

```bash
$ php composer.phar install
```

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

## Copyright

Copyright (C) 2013 Dai Akatsuka, released under the MIT License.
