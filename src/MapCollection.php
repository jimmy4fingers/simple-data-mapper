<?php

namespace DataMapper;

use DataMapper\Interfaces\MapCollectionInterface;
use DataMapper\Interfaces\MapInterface;

class MapCollection implements MapCollectionInterface
{
    private $collection;

    /**
     * @return array
     */
    public function get()
    {
        return $this->collection;
    }

    public function add(MapInterface $map)
    {
        $this->collection[$map->getKey()] = $map;
    }
}
