<?php

namespace DataMapper;

use DataMapper\Interfaces\MapperInterface;
use DataMapper\Interfaces\MapCollectionInterface;

/**
 * Class Mapper
 */
class Mapper implements MapperInterface
{
    private $mapperObj;
    private $mapping;
    private $lookup;

    /**
     * gets full array map
     *
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        if (empty($this->mapping))
            throw new \Exception('Cannot call get before setting mappings via "load" or "set"');

        return $this->mapping;
    }

    /**
     * get data by key
     *
     * @param $key
     * @return mixed
     */
    public function getData($key)
    {
        if (array_key_exists($key, $this->mapping))
            return $this->mapping[$key]->getData();
    }

    /**
     * load data into $mappings
     *
     * @param MapCollectionInterface $mappings
     *
     * @param $data
     */
    public function setDataByLookupKey(MapCollectionInterface $mappings, $data)
    {
        $this->mapperObj = $mappings;
        $this->mapping = $mappings->get();
        $this->setLookup();
        $this->setLoadData($data);
    }

    /**
     * set data into $mappings
     *
     * @param MapCollectionInterface $mappings
     * @param $data
     */
    public function setDataByKey(MapCollectionInterface $mappings, $data)
    {
        $this->mapperObj = $mappings;
        $this->mapping = $mappings->get();
        $this->setData($data);
    }

    /**
     * get mapping by [key => data]
     *
     * @return array|mixed
     */
    public function getWithData()
    {
        if (empty($this->mapping))
            throw new \LogicException('Cannot call getWithData before set.');

        foreach ($this->mapping as $key => $value) {
            $mapWithData[$key] = $value->getData();
        }

        return $mapWithData;
    }

    /**
     * loading data from D3
     *
     * @param array $keyValueData ['lookup' => value]
     */
    private function setLoadData(array $keyValueData)
    {
        foreach ($keyValueData as $key => $value) {
            // if lookup key exists, set the data
            if (array_key_exists($key, $this->lookup)) {

                $this->mapping[$this->lookup[$key]]->setData($value);
                $onLoad = $this->mapping[$this->lookup[$key]]->getOnLoad();

                if (is_callable($onLoad)) {
                    $this->mapping[$this->lookup[$key]]->setData(
                        $this->onLoadHandler($onLoad, $value)
                    );
                }
            }
        }
    }

    /**
     * setting data from a form
     *
     * @param array $keyValueData ['key' => value]
     */
    private function setData(array $keyValueData)
    {
        foreach ($keyValueData as $key => $data) {
            // if key exists set the data
            if (array_key_exists($key, $this->mapping)) {
                $this->mapping[$key]->setData($data);

                $onSet = $this->mapping[$key]->getOnSet();
                if (is_callable($onSet)) {
                    $this->mapping[$key]->setData(
                        $this->onSetHandler($onSet, $data)
                    );
                }
            }
        }
    }

    /**
     * sets a look up array
     */
    private function setLookup()
    {
        foreach ($this->mapping as $map) {
            $this->lookup[$map->getLookup()] = $map->getKey();
        }
    }

    private function onSetHandler($onSet, $data)
    {
        return $onSet($data);
    }

    private function onLoadHandler($onLoad, $data)
    {
        return $onLoad($data);
    }
}
