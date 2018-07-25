<?php

namespace DataMapper;

use DataMapper\Interfaces\MapInterface;
use DataMapper\Interfaces\MapperInterface;
use DataMapper\Interfaces\MapCollectionInterface;

class Mapper implements MapperInterface
{
    /** @var MapCollectionInterface */
    private $mapCollection;
    /** @var MapInterface[] */
    private $mapping;
    /** @var array */
    private $lookup;

    /**
     * @param $key
     * @return MapInterface[]|MapInterface
     * @throws \Exception
     */
    public function get($key = null)
    {
        if (empty($this->mapping)) {
            throw new \Exception('A MapCollectionInterface must be set before calling this method.');
        }

        if (!is_null($key) && array_key_exists($key, $this->mapping)) {
            return $this->mapping[$key];
        }

        return $this->mapping;
    }

    /**
     * returns ['mapping key' => data] or ['lookup key' => data] if $lookupAsKey = true
     *
     * @param bool $lookupAsKey
     * @return array
     * @throws \Exception
     */
    public function getArray($lookupAsKey = false)
    {
        if (empty($this->mapping)) {
            throw new \Exception('A MapCollectionInterface must be set before calling this method.');
        }

        $dataMap = [];
        foreach ($this->mapping as $key => $value) {
            if ($lookupAsKey) {
                $dataMap[$value->getLookup()] = $value->getData();
            } else {
                $dataMap[$key] = $value->getData();
            }
        }

        return $dataMap;
    }

    /**
     * set MapCollection and map $data to it
     *
     * @param MapCollectionInterface $collection
     * @param array $data
     * @param bool $mapWithLookupKey
     */
    public function set(MapCollectionInterface $collection, array $data, $mapWithLookupKey = false)
    {
        $this->mapCollection = $collection;
        $this->mapping = $collection->get();
        $this->setLookup();

        if ($mapWithLookupKey) {
            $this->mapDataByLookupKey($data);
        } else {
            $this->mapDataByKey($data);
        }
    }

    private function mapDataByLookupKey(array $data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->lookup)) {
                $onLoad = $this->mapping[$this->lookup[$key]]->getOnMapByLookup();
                if (is_callable($onLoad)) {
                    $this->mapping[$this->lookup[$key]]->setData(
                        $this->onMapDataLookupHandler($onLoad, $value)
                    );
                } else {
                    $this->mapping[$this->lookup[$key]]->setData($value);
                }
            }
        }
    }

    private function mapDataByKey(array $data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->mapping)) {
                $onSet = $this->mapping[$key]->getOnMap();
                if (is_callable($onSet)) {
                    $this->mapping[$key]->setData(
                        $this->onMapDataHandler($onSet, $value)
                    );
                } else {
                    $this->mapping[$key]->setData($value);
                }
            }
        }
    }

    private function setLookup()
    {
        foreach ($this->mapping as $map) {
            $this->lookup[$map->getLookup()] = $map->getKey();
        }
    }

    private function onMapDataHandler($onSet, $data)
    {
        return $onSet($data);
    }

    private function onMapDataLookupHandler($onLoad, $data)
    {
        return $onLoad($data);
    }
}
