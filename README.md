# Simple Data Mapper
[![Build Status](https://travis-ci.org/jimmy4fingers/simple-data-mapper.svg?branch=master)](https://travis-ci.org/jimmy4fingers/simple-data-mapper)

Collection of objects intended to cut down repetition of code when having to re-map arrays of data with another source (DB field's etc.)

E.g:
```php
<?php

// form data
$postData = [
    'my-form-field-name' => 'jim',
    'my-form-field-email' => 'jim@email.com',
    'my-form-field-age' => 36
];

// data to insert
$entityData = [
    'name' => $postData['my-form-field-name'],
    'email_address' => $postData['my-form-field-email'],
    'users_age' => $postData['my-form-field-age']
];
```

if you want to also add validation or additional logic then you would expect to reference the key\value pair again and so on...

Alternatively, we can add a mapping object.

E.g:
```php
<?php

use DataMapper\Map;
use DataMapper\MapCollection;
use DataMapper\Mapper;

$map = new Map();
$collection = new MapCollection();
$mapper = new Mapper();

// post data example
$data = [
    'my-form-field-name' => 'jim'
];

// create a collection of mappings
$collection->add(
    // [application reference], [lookup key]
    $map->set('my-form-field-name', 'name')
);

// pass data into the mapper along with the collection
$mapper->set($collection, $data);

$name = $mapper->get('my-form-field-name')->getData();
// $name = 'jim';

``` 
While the above seems trivial, let's try and reverse the process. We want to load some data and assign it to our application key ('my-form-field-name').

```php
<?php

use DataMapper\Map;
use DataMapper\MapCollection;
use DataMapper\Mapper;

$map = new Map();
$collection = new MapCollection();
$mapper = new Mapper();

// loaded data example
$data = ['name' => 'jimmy'];

// create a collection of mappings
$collection->add($map->set('my-form-field-name', 'name'));

// the last parameter tells the mapper to map data using the lookup key
$mapper->set($collection, $data, true);

$name = $mapper->get('my-form-field-name')->getData();
// $name = 'jimmy';
```
## Additional functionality

You can pass anonymous functions to be triggered when data is loaded in via Mapper::set. The anonymous function must accept a parameter of data and also return it.
- setOnMap() - triggered when mapping data via key
- setOnMapByLookup() - triggered when setting data via lookup key

E.g:
```php
<?php
use DataMapper\Map;
use DataMapper\MapCollection;
use DataMapper\Mapper;

$map = new Map();
$collection = new MapCollection();
$mapper = new Mapper();

$ucwordsCallback = function ($data) {
    return ucwords($data);
};

$maps = [
    $map->set('first-name','first_names')->setOnMap($ucwordsCallback),
    $map->set('last-name','last_name')->setOnMap($ucwordsCallback),
    $map->set('email','email_address'),
    $map->set('address_line1','line_1'),
    $map->set('address_line1','line_2'),
    $map->set('address_line1','line_3')
];
foreach($maps as $map) {
    $collection->add($map);
}

// posted data example
$postData = [
    'first-name' => 'jimmy jams',
    'last-name' => 'higgins',
];

$mapper->set($collection, $postData);

$myData = $mapper->getArray();
// $myData = ['first-name' => 'Jimmy Jams' etc...];
```

 - setDataFrom()
 
 If the array of data you are mapping contains data you wish to set on a Map but is not referenced by a mapping key or lookup key, you can use the Map::setDataFrom($key).
 
 E.g:
 ```php
 <?php
 // data your mapping
 $post = [
     'jsonData' => ['city1', 'city2', 'city3']
];
 
 $map = new Map();
 $collection = new MapCollection();
 $mapper = new Mapper();
 
 $cb1 = function ($data) {
     $data = json_decode($data,true);
     if (is_array($data) && array_key_exists(0,$data))
        $data = $data[0];
     return $data;
 };
 $cb2 = function ($data) {
      $data = json_decode($data,true);
      if (is_array($data) && array_key_exists(1,$data))
         $data = $data[1];
      return $data;
  };
  
 $maps = [
     $map->set('city1','city_1')->setDataFrom('jsonData')->setOnMap($cb1),
     $map->set('city2','city_2')->setDataFrom('jsonData')->setOnMap($cb2)
 ];
 foreach($maps as $map) {
     $collection->add($map);
 }
 
 $mapper->set($collection, $post);
 
 $myData = $mapper->getArray();
 // $myData = ['city1' => 'city1', 'city2' => 'city2']
 
 ```

### Extend

The Map object can set a few more values that you can use to extend the functionality of Mapper::class.

- setValidation()
- setFormObject()

E.g:
```php
<?php
use DataMapper\Map;
use DataMapper\MapCollection;
use DataMapper\Mapper;

$map = new Map();
$collection = new MapCollection();
$mapper = new Mapper();

$maps = [
    $map->set('first-name','first_names')->setValidation('required'),
    $map->set('last-name','last_name')->setValidation('required'),
    $map->set('email','email_address')->setValidation('required|email'),
];
foreach($maps as $map) {
    $collection->add($map);
}

$mapper->set($collection, ['first-name'=>'bob', 'last-name'=>'']);

$validation = new ValidationObject();
$validation->validateMapped($mapper->get()); // Mapper::get returns MapInterface[]
if ($validation->isValid()) {
    //...
}
```
