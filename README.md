# Simple Data Mapper

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
While the above seems trivial, let's try and reverse the process. We want to load some data and assign it to our application key or 'my-form-field-name'.

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
