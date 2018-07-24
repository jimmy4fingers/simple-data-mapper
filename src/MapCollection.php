<?php

class MapCollection implements MapCollectionInterface
{
    private $collection;

    public function get()
    {
        return $this->collection;
    }

    public function add(MapInterface $map)
    {
        $this->collection[$map->getKey()] = $map;
    }
}
