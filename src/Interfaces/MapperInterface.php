<?php
/**
 * Created by PhpStorm.
 * User: jamesle
 * Date: 20/07/2018
 * Time: 10:39
 */

namespace DataMapper\Interfaces;

interface MapperInterface
{
    public function get($key);
    public function set(MapCollectionInterface $mappings, array $data, $mapWithLookupKey = false);
    public function getArray($lookupAsKey = false);
}