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
    /**
     * gets full array map
     *
     * @return array
     * @throws Exception
     */
    public function get();

    /**
     * get data by key
     *
     * @param $key
     * @return mixed
     */
    public function getData($key);

    /**
     * load data into $mappings
     *
     * @param MapCollectionInterface $mappings
     *
     * @param $data
     */
    public function setDataByLookupKey(MapCollectionInterface $mappings, $data);

    /**
     * set data into $mappings
     *
     * @param MapCollectionInterface $mappings
     * @param $data
     */
    public function setDataByKey(MapCollectionInterface $mappings, $data);

    /**
     * get mapping by [key => data]
     *
     * @return array
     */
    public function getWithData();
}